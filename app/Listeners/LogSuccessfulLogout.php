<?php

namespace App\Listeners;

use App\Models\Branch;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;

class LogSuccessfulLogout
{
    public function __construct(private Request $request) {}

    public function handle(Logout $event): void
    {
        activity('auth')
            ->causedBy($event->user)
            ->withProperties([
                'branch' => Branch::query()->find(session('branch_id'))?->name,
                'ip' => $this->request->ip(),
            ])
            ->event('logout')
            ->log('User logged out');
    }
}
