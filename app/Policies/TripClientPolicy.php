<?php

namespace App\Policies;

use App\Models\TripClient;
use App\Models\User;

class TripClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyTripClient');
    }

    public function view(User $user, TripClient $tripClient): bool
    {
        return $user->can('viewTripClient');
    }

    public function create(User $user): bool
    {
        return $user->can('createTripClient');
    }

    public function update(User $user, TripClient $tripClient): bool
    {
        return $user->can('updateTripClient');
    }

    public function delete(User $user, TripClient $tripClient): bool
    {
        return $user->can('deleteTripClient');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyTripClient');
    }
}
