<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyUser');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('viewUser');
    }

    public function create(User $user): bool
    {
        return $user->can('createUser');
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('updateUser');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('deleteUser');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyUser');
    }
}
