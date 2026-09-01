<?php

namespace App\Policies;

use App\Models\Branch;
use App\Models\User;

class BranchPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyBranch');
    }

    public function view(User $user, Branch $branch): bool
    {
        return $user->can('viewBranch');
    }

    public function create(User $user): bool
    {
        return $user->can('createBranch');
    }

    public function update(User $user, Branch $branch): bool
    {
        return $user->can('updateBranch');
    }

    public function delete(User $user, Branch $branch): bool
    {
        return $user->can('deleteBranch');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyBranch');
    }
}
