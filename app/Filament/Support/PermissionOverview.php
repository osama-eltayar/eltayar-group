<?php

namespace App\Filament\Support;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionOverview
{
    /**
     * Build one infolist Section per permission group, listing every permission
     * in the system with a granted / not-granted indicator.
     *
     * @param  array<int>  $grantedPermissionIds
     * @return array<Section>
     */
    public static function sections(array $grantedPermissionIds): array
    {
        return Permission::query()->get()
            ->groupBy('group')
            ->map(fn (Collection $permissions, string $group): Section => Section::make(PermissionLabel::group($group))
                ->schema([
                    Grid::make(3)->schema(
                        $permissions->map(fn (Permission $permission): TextEntry => static::entry($permission, $grantedPermissionIds))->values()->all()
                    ),
                ]))
            ->values()
            ->all();
    }

    /**
     * Build one infolist Section per permission group, listing only the
     * permissions actually granted (no granted/not-granted distinction needed).
     *
     * @param  array<int>  $grantedPermissionIds
     * @return array<Section>
     */
    public static function grantedSections(array $grantedPermissionIds): array
    {
        return Permission::query()->whereIn('id', $grantedPermissionIds)->get()
            ->groupBy('group')
            ->map(fn (Collection $permissions, string $group): Section => Section::make(PermissionLabel::group($group))
                ->schema([
                    TextEntry::make('granted_'.$group)
                        ->hiddenLabel()
                        ->badge()
                        ->color('success')
                        ->state($permissions->map(fn (Permission $permission): string => PermissionLabel::action($permission))->values()->all()),
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
