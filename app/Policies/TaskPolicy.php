<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyTask');
    }

    public function view(User $user, Task $task): bool
    {
        return $user->can('viewTask');
    }

    public function create(User $user): bool
    {
        return $user->can('createTask');
    }

    public function update(User $user, Task $task): bool
    {
        return $user->can('updateTask');
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->can('deleteTask');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyTask');
    }

    public function complete(User $user, Task $task): bool
    {
        return $task->created_by === $user->id;
    }

    public function cancel(User $user, Task $task): bool
    {
        return $task->created_by === $user->id;
    }
}
