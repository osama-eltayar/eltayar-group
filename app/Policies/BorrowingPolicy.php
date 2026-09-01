<?php

namespace App\Policies;

use App\Models\Borrowing;
use App\Models\User;

class BorrowingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyBorrowing');
    }

    public function view(User $user, Borrowing $borrowing): bool
    {
        return $user->can('viewBorrowing');
    }

    public function create(User $user): bool
    {
        return $user->can('createBorrowing');
    }

    public function update(User $user, Borrowing $borrowing): bool
    {
        return $user->can('updateBorrowing') && $borrowing->logs()->doesntExist();
    }

    public function delete(User $user, Borrowing $borrowing): bool
    {
        return $user->can('deleteBorrowing');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyBorrowing');
    }
}
