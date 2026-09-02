<?php

namespace App\Services\Task;

use App\Enums\TaskStatus;
use App\Models\Task;

class CompleteTaskService
{
    public function execute(Task $task): void
    {
        $task->update([
            'status' => TaskStatus::Completed,
            'finished_at' => now(),
        ]);
    }
}
