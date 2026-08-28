<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Http\Requests\AcceptInvitationRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class InvitationController extends Controller
{
    public function show(string $token): View|RedirectResponse
    {
        $user = User::where('invitation_token', $token)->first();

        if (! $user) {
            return redirect()->route('filament.dashboard.auth.login');
        }

        return view('invitations.show', ['user' => $user, 'token' => $token]);
    }

    public function store(AcceptInvitationRequest $request, string $token): RedirectResponse
    {
        $user = User::where('invitation_token', $token)->firstOrFail();

        $user->update([
            'password' => $request->validated('password'),
            'status' => UserStatus::Active,
            'invitation_token' => null,
        ]);

        return redirect()
            ->route('filament.dashboard.auth.login')
            ->with('status', __('user.invitation_accepted'));
    }
}
