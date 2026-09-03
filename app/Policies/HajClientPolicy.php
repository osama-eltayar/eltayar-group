<?php

namespace App\Policies;

use App\Models\HajClient;
use App\Models\User;

class HajClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyHajClient');
    }

    public function view(User $user, HajClient $hajClient): bool
    {
        return $user->can('viewHajClient');
    }

    public function create(User $user): bool
    {
        return $user->can('createHajClient');
    }

    public function update(User $user, HajClient $hajClient): bool
    {
        return $user->can('updateHajClient');
    }

    public function delete(User $user, HajClient $hajClient): bool
    {
        return $user->can('deleteHajClient');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyHajClient');
    }

    public function applyDiscount(User $user, HajClient $hajClient): bool
    {
        return $user->can('applyDiscountHajClient');
    }

    public function markSuccessful(User $user, HajClient $hajClient): bool
    {
        return $user->can('markSuccessfulHajClient');
    }

    public function markUnsuccessful(User $user, HajClient $hajClient): bool
    {
        return $user->can('markUnsuccessfulHajClient');
    }

    public function markReserve(User $user, HajClient $hajClient): bool
    {
        return $user->can('markReserveHajClient');
    }

    public function markWithdrawn(User $user, HajClient $hajClient): bool
    {
        return $user->can('markWithdrawnHajClient');
    }
}
