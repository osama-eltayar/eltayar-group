<?php

namespace App\Policies;

use App\Models\Haj;
use App\Models\User;

class HajPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyHaj');
    }

    public function view(User $user, Haj $haj): bool
    {
        return $user->can('viewHaj');
    }

    public function create(User $user): bool
    {
        return $user->can('createHaj');
    }

    public function update(User $user, Haj $haj): bool
    {
        return $user->can('updateHaj');
    }

    public function delete(User $user, Haj $haj): bool
    {
        return $user->can('deleteHaj');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyHaj');
    }
}
