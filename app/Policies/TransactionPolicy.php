<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyTransaction');
    }

    public function view(User $user, Transaction $transaction): bool
    {
        return $user->can('viewTransaction');
    }

    public function create(User $user): bool
    {
        return $user->can('createTransaction');
    }

    public function update(User $user, Transaction $transaction): bool
    {
        // Transactions are immutable once recorded, regardless of permissions.
        return false;
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->can('deleteTransaction');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyTransaction');
    }
}
