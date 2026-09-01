<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyRole');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('viewRole');
    }

    public function create(User $user): bool
    {
        return $user->can('createRole');
    }

    public function update(User $user, Role $role): bool
    {
        // Roles are seeded and code-referenced; renaming or re-scoping them from the UI is not allowed.
        return false;
    }

    public function delete(User $user, Role $role): bool
    {
        // Roles can never be deleted from the UI.
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function managePermissions(User $user, Role $role): bool
    {
        return $user->can('updateRole');
    }
}
