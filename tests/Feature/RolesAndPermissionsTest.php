<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolesAndPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_super_admin_bypasses_every_permission_check(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(RoleEnum::SuperAdmin->value);

        $this->assertTrue(Gate::forUser($superAdmin)->allows('viewAnyBooking'));
        $this->assertTrue(Gate::forUser($superAdmin)->allows('create', Booking::class));
        $this->assertTrue(Gate::forUser($superAdmin)->allows('a-permission-that-does-not-exist'));
    }

    public function test_user_without_permission_is_denied(): void
    {
        $employee = User::factory()->create();
        $employee->assignRole(RoleEnum::Employee->value);

        $this->assertFalse(Gate::forUser($employee)->allows('viewAny', Booking::class));
        $this->assertFalse(Gate::forUser($employee)->allows('create', Booking::class));
    }

    public function test_granting_a_permission_to_a_role_authorizes_it(): void
    {
        $employee = User::factory()->create();
        $employee->assignRole(RoleEnum::Employee->value);
        $employee->getRoleNames(); // warm relation cache before granting

        $role = Role::findByName(RoleEnum::Employee->value);
        $role->givePermissionTo('viewAnyBooking');

        $this->assertTrue(Gate::forUser($employee->fresh())->allows('viewAny', Booking::class));
        $this->assertFalse(Gate::forUser($employee->fresh())->allows('create', Booking::class));
    }

    public function test_granting_a_permission_directly_to_a_user_authorizes_it(): void
    {
        $employee = User::factory()->create();
        $employee->assignRole(RoleEnum::Employee->value);
        $employee->givePermissionTo('createBooking');

        $this->assertTrue(Gate::forUser($employee)->allows('create', Booking::class));
        $this->assertFalse(Gate::forUser($employee)->allows('viewAny', Booking::class));
    }

    public function test_transactions_can_never_be_updated_even_with_permission(): void
    {
        $superAdminMinusBypass = User::factory()->create();
        $superAdminMinusBypass->assignRole(RoleEnum::Admin->value);

        $transaction = Transaction::factory()->create();

        $this->assertFalse(Gate::forUser($superAdminMinusBypass)->allows('update', $transaction));
    }
}
