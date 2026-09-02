<?php

namespace App\Services\Task;

use App\Enums\TaskAssignmentStatus;
use App\Enums\TaskCompletionMode;
use App\Enums\TaskStatus;
use App\Models\TaskAssignment;

class MarkTaskAssignmentDoneService
{
    public function execute(TaskAssignment $assignment, ?string $comment): void
    {
        $assignment->update([
            'status' => TaskAssignmentStatus::Completed,
            'comment' => $comment,
            'completed_at' => now(),
        ]);

        $task = $assignment->task;

        $shouldCompleteTask = $task->completion_mode === TaskCompletionMode::RequireAny
            || $task->assignments()->where('status', TaskAssignmentStatus::Pending)->doesntExist();

        if ($shouldCompleteTask) {
            $task->update([
                'status' => TaskStatus::Completed,
                'finished_at' => now(),
            ]);
        }
    }
}
