<?php

namespace App\Filament\Support;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionLabel
{
    public static function for(Permission $permission): string
    {
        return static::action($permission).' — '.static::group($permission->group);
    }

    public static function action(Permission $permission): string
    {
        $action = substr($permission->name, 0, -strlen($permission->group));

        $actionKey = 'enums.permission_actions.'.$action;

        return Lang::has($actionKey) ? __($actionKey) : Str::headline($action);
    }

    public static function group(string $group): string
    {
        $groupKey = Str::snake($group).'.label';

        return Lang::has($groupKey) ? __($groupKey) : $group;
    }
}
