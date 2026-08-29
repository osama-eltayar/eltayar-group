<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->updateOrCreate([
            'email' => 'super-admin@eltayar.com',
        ], [
            'name' => 'Super Admin',
            'status' => 'active',
            'password' => bcrypt(env('SUPER_ADMIN_PASSWORD', '4nu@q(@@98')),
        ]);

        $user->assignRole(RoleEnum::SuperAdmin->value);
    }
}
