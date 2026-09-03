<?php

namespace App\Policies;

use App\Models\OmraClient;
use App\Models\User;

class OmraClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyOmraClient');
    }

    public function view(User $user, OmraClient $omraClient): bool
    {
        return $user->can('viewOmraClient');
    }

    public function create(User $user): bool
    {
        return $user->can('createOmraClient');
    }

    public function update(User $user, OmraClient $omraClient): bool
    {
        return $user->can('updateOmraClient');
    }

    public function delete(User $user, OmraClient $omraClient): bool
    {
        return $user->can('deleteOmraClient');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyOmraClient');
    }
}
