<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyPermission');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->can('viewPermission');
    }

    public function create(User $user): bool
    {
        return $user->can('createPermission');
    }

    public function update(User $user, Permission $permission): bool
    {
        // Permissions are code-referenced by name; renaming them from the UI is not allowed.
        return false;
    }

    public function delete(User $user, Permission $permission): bool
    {
        // Permissions can never be deleted from the UI.
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
