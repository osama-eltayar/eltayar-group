<?php

namespace App\Services\Task;

use App\Enums\TaskStatus;
use App\Models\Task;

class CancelTaskService
{
    public function execute(Task $task): void
    {
        $task->update([
            'status' => TaskStatus::Cancelled,
            'finished_at' => now(),
        ]);
    }
}
