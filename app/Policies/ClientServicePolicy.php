<?php

namespace App\Policies;

use App\Models\ClientService;
use App\Models\User;

class ClientServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyClientService');
    }

    public function view(User $user, ClientService $clientService): bool
    {
        return $user->can('viewClientService');
    }

    public function create(User $user): bool
    {
        return $user->can('createClientService');
    }

    public function update(User $user, ClientService $clientService): bool
    {
        return $user->can('updateClientService');
    }

    public function delete(User $user, ClientService $clientService): bool
    {
        return $user->can('deleteClientService');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyClientService');
    }
}
