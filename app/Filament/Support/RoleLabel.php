<?php

namespace App\Filament\Support;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleLabel
{
    public static function for(Role $role): string
    {
        $key = 'enums.role_enum.'.$role->name;

        return Lang::has($key) ? __($key) : Str::headline($role->name);
    }
}
