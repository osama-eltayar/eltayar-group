<?php

namespace App\Policies;

use App\Models\OmraPrice;
use App\Models\User;

class OmraPricePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyOmraPrice');
    }

    public function view(User $user, OmraPrice $omraPrice): bool
    {
        return $user->can('viewOmraPrice');
    }

    public function create(User $user): bool
    {
        return $user->can('createOmraPrice');
    }

    public function update(User $user, OmraPrice $omraPrice): bool
    {
        return $user->can('updateOmraPrice');
    }

    public function delete(User $user, OmraPrice $omraPrice): bool
    {
        return $user->can('deleteOmraPrice');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyOmraPrice');
    }
}
