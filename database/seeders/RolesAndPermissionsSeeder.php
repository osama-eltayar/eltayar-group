<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $modelsNeedPermissions = [
            'User',
            'Role',
            'Permission',
        ];

        $permissions = [
            'viewAny',
            'view',
            'update',
            'create',
            'delete',
            'destroy',
            'restore',
            'forceDelete',
        ];

        foreach ($modelsNeedPermissions as $modelNeedPermission) {
            foreach ($permissions as $permission) {
                Permission::query()->firstOrCreate(['group' => $modelNeedPermission, 'name' => $permission . $modelNeedPermission]);
            }
        }

        // Create a Super-Admin Role and assign all Permissions
        $role = Role::query()->firstOrCreate(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        $role = Role::query()->firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
