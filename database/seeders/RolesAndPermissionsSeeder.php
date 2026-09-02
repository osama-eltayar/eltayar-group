<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Models that get the standard CRUD permission set.
     *
     * @var list<string>
     */
    private const MODELS_NEEDING_PERMISSIONS = [
        'User',
        'Role',
        'Permission',
        'Booking',
        'Borrowing',
        'Branch',
        'Client',
        'ClientService',
        'Salary',
        'Task',
        'Transaction',
        'Trip',
        'TripClient',
        'TripPrice',
    ];

    /**
     * Standard CRUD actions generated for every model above.
     *
     * @var list<string>
     */
    private const CRUD_ACTIONS = [
        'viewAny',
        'view',
        'create',
        'update',
        'delete',
        'deleteAny',
    ];

    /**
     * Additional, non-CRUD business actions, keyed by model.
     *
     * @var array<string, list<string>>
     */
    private const CUSTOM_ACTIONS = [
        'Booking' => ['applyDiscount'],
        'Salary' => ['endSalary'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::MODELS_NEEDING_PERMISSIONS as $model) {
            $actions = [...self::CRUD_ACTIONS, ...self::CUSTOM_ACTIONS[$model] ?? []];

            foreach ($actions as $action) {
                Permission::query()->firstOrCreate(['group' => $model, 'name' => $action.$model]);
            }
        }

        // Super-Admin and Admin roles always have every permission the system knows about.
        $superAdmin = Role::query()->firstOrCreate(['name' => RoleEnum::SuperAdmin->value]);
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::query()->firstOrCreate(['name' => RoleEnum::Admin->value]);
        $admin->syncPermissions(Permission::all());

        // Employees start with no permissions; an admin assigns them as needed.
        Role::query()->firstOrCreate(['name' => RoleEnum::Employee->value]);
    }
}
