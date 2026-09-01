<?php

namespace App\Filament\Support;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionOverview
{
    /**
     * Build one infolist Tab per permission group, listing every permission
     * with a granted / not-granted indicator.
     *
     * @param  array<int>  $grantedPermissionIds
     * @return array<Tab>
     */
    public static function tabs(array $grantedPermissionIds): array
    {
        return Permission::query()->get()
            ->groupBy('group')
            ->map(fn (Collection $permissions, string $group): Tab => Tab::make($group)
                ->label(PermissionLabel::group($group))
                ->schema([
                    Grid::make(3)->schema(
                        $permissions->map(fn (Permission $permission): TextEntry => static::entry($permission, $grantedPermissionIds))->values()->all()
                    ),
                ]))
            ->values()
            ->all();
    }

    /**
     * @param  array<int>  $grantedPermissionIds
     */
    private static function entry(Permission $permission, array $grantedPermissionIds): TextEntry
    {
        $granted = in_array($permission->id, $grantedPermissionIds, true);

        return TextEntry::make('permission_'.$permission->id)
            ->label(PermissionLabel::action($permission))
            ->state($granted ? __('permission.granted') : __('permission.not_granted'))
            ->badge()
            ->color($granted ? 'success' : 'gray')
            ->icon($granted ? Heroicon::CheckCircle : Heroicon::XCircle);
    }
}
