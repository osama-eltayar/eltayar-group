<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyClient');
    }

    public function view(User $user, Client $client): bool
    {
        return $user->can('viewClient');
    }

    public function create(User $user): bool
    {
        return $user->can('createClient');
    }

    public function update(User $user, Client $client): bool
    {
        return $user->can('updateClient');
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->can('deleteClient');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyClient');
    }
}
