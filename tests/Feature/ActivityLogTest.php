<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_creation_is_logged_with_causer_and_active_branch(): void
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create();

        $this->actingAs($user);
        session(['branch_id' => $branch->id]);

        $newBranch = Branch::factory()->create();

        $activity = Activity::query()
            ->forSubject($newBranch)
            ->forEvent('created')
            ->latest('id')
            ->first();

        $this->assertNotNull($activity);
        $this->assertSame($user->id, $activity->causer_id);
        $this->assertSame($branch->name, $activity->properties->get('branch'));
    }

    public function test_login_is_logged_with_active_branch(): void
    {
        $branch = Branch::factory()->create();
        $user = User::factory()->create();

        Livewire::test(Login::class)
            ->fillForm([
                'email' => $user->email,
                'password' => 'password',
                'branch_id' => $branch->id,
            ])
            ->call('authenticate');

        $activity = Activity::query()
            ->inLog('auth')
            ->forEvent('login')
            ->latest('id')
            ->first();

        $this->assertNotNull($activity);
        $this->assertSame($user->id, $activity->causer_id);
        $this->assertSame($branch->name, $activity->properties->get('branch'));
        $this->assertSame($branch->id, session('branch_id'));
    }

    public function test_logout_is_logged_with_active_branch(): void
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create();

        $this->actingAs($user);
        session(['branch_id' => $branch->id]);

        $this->post(route('filament.dashboard.auth.logout'));

        $activity = Activity::query()
            ->inLog('auth')
            ->forEvent('logout')
            ->latest('id')
            ->first();

        $this->assertNotNull($activity);
        $this->assertSame($user->id, $activity->causer_id);
        $this->assertSame($branch->name, $activity->properties->get('branch'));
    }
}
