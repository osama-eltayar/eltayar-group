<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;

class TripPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyTrip');
    }

    public function view(User $user, Trip $trip): bool
    {
        return $user->can('viewTrip');
    }

    public function create(User $user): bool
    {
        return $user->can('createTrip');
    }

    public function update(User $user, Trip $trip): bool
    {
        return $user->can('updateTrip');
    }

    public function delete(User $user, Trip $trip): bool
    {
        return $user->can('deleteTrip');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyTrip');
    }
}
