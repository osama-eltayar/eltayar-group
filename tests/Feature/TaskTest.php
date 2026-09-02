<?php

namespace Tests\Feature;

use App\Enums\TaskAssignmentStatus;
use App\Enums\TaskCompletionMode;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use App\Services\Task\CancelTaskService;
use App\Services\Task\CompleteTaskService;
use App\Services\Task\MarkTaskAssignmentDoneService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_multiple_assignees_reflects_assignment_count(): void
    {
        $task = Task::factory()->create();
        $task->assignees()->attach(User::factory()->create());

        $this->assertFalse($task->hasMultipleAssignees());

        $task->assignees()->attach(User::factory()->create());

        $this->assertTrue($task->refresh()->hasMultipleAssignees());
    }

    public function test_require_any_completion_mode_completes_task_after_a_single_assignee_marks_done(): void
    {
        $task = Task::factory()->pending()->create([
            'completion_mode' => TaskCompletionMode::RequireAny,
        ]);
        $assignee1 = User::factory()->create();
        $assignee2 = User::factory()->create();
        $task->assignees()->attach([$assignee1->id, $assignee2->id]);

        $assignment = $task->assignments()->where('user_id', $assignee1->id)->first();

        app(MarkTaskAssignmentDoneService::class)->execute($assignment, '<p>done</p>');

        $task->refresh();
        $this->assertSame(TaskStatus::Completed, $task->status);
        $this->assertNotNull($task->finished_at);
        $this->assertSame(TaskAssignmentStatus::Completed, $assignment->refresh()->status);
        $this->assertSame('<p>done</p>', $assignment->comment);

        $otherAssignment = $task->assignments()->where('user_id', $assignee2->id)->first();
        $this->assertSame(TaskAssignmentStatus::Pending, $otherAssignment->status);
    }

    public function test_require_all_completion_mode_waits_for_every_assignee_to_mark_done(): void
    {
        $task = Task::factory()->pending()->create([
            'completion_mode' => TaskCompletionMode::RequireAll,
        ]);
        $assignee1 = User::factory()->create();
        $assignee2 = User::factory()->create();
        $task->assignees()->attach([$assignee1->id, $assignee2->id]);

        $assignment1 = $task->assignments()->where('user_id', $assignee1->id)->first();
        app(MarkTaskAssignmentDoneService::class)->execute($assignment1, null);

        $this->assertSame(TaskStatus::Pending, $task->refresh()->status);

        $assignment2 = $task->assignments()->where('user_id', $assignee2->id)->first();
        app(MarkTaskAssignmentDoneService::class)->execute($assignment2, null);

        $task->refresh();
        $this->assertSame(TaskStatus::Completed, $task->status);
        $this->assertNotNull($task->finished_at);
    }

    public function test_complete_task_service_completes_the_task(): void
    {
        $task = Task::factory()->pending()->create();

        app(CompleteTaskService::class)->execute($task);

        $task->refresh();
        $this->assertSame(TaskStatus::Completed, $task->status);
        $this->assertNotNull($task->finished_at);
    }

    public function test_cancel_task_service_cancels_the_task(): void
    {
        $task = Task::factory()->pending()->create();

        app(CancelTaskService::class)->execute($task);

        $task->refresh();
        $this->assertSame(TaskStatus::Cancelled, $task->status);
        $this->assertNotNull($task->finished_at);
    }

    public function test_only_the_creator_can_complete_or_cancel_the_task(): void
    {
        $creator = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->pending()->create(['created_by' => $creator->id]);

        $policy = new TaskPolicy;

        $this->assertTrue($policy->complete($creator, $task));
        $this->assertTrue($policy->cancel($creator, $task));
        $this->assertFalse($policy->complete($otherUser, $task));
        $this->assertFalse($policy->cancel($otherUser, $task));
    }
}
