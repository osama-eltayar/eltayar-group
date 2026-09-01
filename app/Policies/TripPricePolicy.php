<?php

namespace App\Policies;

use App\Models\TripPrice;
use App\Models\User;

class TripPricePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyTripPrice');
    }

    public function view(User $user, TripPrice $tripPrice): bool
    {
        return $user->can('viewTripPrice');
    }

    public function create(User $user): bool
    {
        return $user->can('createTripPrice');
    }

    public function update(User $user, TripPrice $tripPrice): bool
    {
        return $user->can('updateTripPrice');
    }

    public function delete(User $user, TripPrice $tripPrice): bool
    {
        return $user->can('deleteTripPrice');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyTripPrice');
    }
}
