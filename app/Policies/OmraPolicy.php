<?php

namespace App\Policies;

use App\Models\Omra;
use App\Models\User;

class OmraPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyOmra');
    }

    public function view(User $user, Omra $omra): bool
    {
        return $user->can('viewOmra');
    }

    public function create(User $user): bool
    {
        return $user->can('createOmra');
    }

    public function update(User $user, Omra $omra): bool
    {
        return $user->can('updateOmra');
    }

    public function delete(User $user, Omra $omra): bool
    {
        return $user->can('deleteOmra');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyOmra');
    }
}
