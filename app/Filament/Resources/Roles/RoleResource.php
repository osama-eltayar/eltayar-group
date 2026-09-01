<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Pages\ViewRole;
use App\Filament\Resources\Roles\Schemas\RoleForm;
use App\Filament\Resources\Roles\Schemas\RoleInfolist;
use App\Filament\Resources\Roles\Tables\RolesTable;
use App\Filament\Support\PermissionLabel;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('role.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('role.label');
    }

    public static function managePermissionsAction(): Action
    {
        return Action::make('managePermissions')
            ->label(__('role.manage_permissions'))
            ->icon(Heroicon::ShieldCheck)
            ->color('gray')
            ->modalWidth(Width::FourExtraLarge)
            ->modalSubmitActionLabel(__('role.save_permissions'))
            ->authorize('managePermissions')
            ->fillForm(fn (Role $record): array => [
                'permissions' => Permission::query()->get()
                    ->groupBy('group')
                    ->map(fn (Collection $permissions): array => $permissions
                        ->whereIn('id', $record->permissions->pluck('id'))
                        ->pluck('id')
                        ->all())
                    ->all(),
            ])
            ->schema([
                Tabs::make('permissionGroups')
                    ->tabs(
                        Permission::query()->get()
                            ->groupBy('group')
                            ->map(fn (Collection $permissions, string $group): Tab => Tab::make($group)
                                ->label(PermissionLabel::group($group))
                                ->schema([
                                    CheckboxList::make("permissions.{$group}")
                                        ->hiddenLabel()
                                        ->options($permissions->mapWithKeys(
                                            fn (Permission $permission): array => [$permission->id => PermissionLabel::action($permission)]
                                        )->all())
                                        ->columns(2),
                                ]))
                            ->values()
                            ->all()
                    ),
            ])
            ->action(function (Role $record, array $data): void {
                $ids = collect($data['permissions'] ?? [])->flatten()->filter()->unique()->values()->all();

                $record->syncPermissions($ids);
            });
    }

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RoleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
        ];
    }
}
