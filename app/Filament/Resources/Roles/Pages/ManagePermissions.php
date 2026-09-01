<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Filament\Support\PermissionLabel;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManagePermissions extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public function getTitle(): string
    {
        return __('role.manage_permissions');
    }

    protected function authorizeAccess(): void
    {
        /** @var Role $record */
        $record = $this->getRecord();

        abort_unless(auth()->user()?->can('managePermissions', $record) ?? false, 403);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components(
                Permission::query()->get()
                    ->groupBy('group')
                    ->map(fn (Collection $permissions, string $group): Section => Section::make(PermissionLabel::group($group))
                        ->schema([
                            CheckboxList::make("permissions.{$group}")
                                ->hiddenLabel()
                                ->options($permissions->mapWithKeys(
                                    fn (Permission $permission): array => [$permission->id => PermissionLabel::action($permission)]
                                )->all())
                                ->columns(3),
                        ]))
                    ->values()
                    ->all()
            )
            ->statePath('data');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var Role $record */
        $record = $this->getRecord();

        $data['permissions'] = Permission::query()->get()
            ->groupBy('group')
            ->map(fn (Collection $permissions): array => $permissions
                ->whereIn('id', $record->permissions->pluck('id'))
                ->pluck('id')
                ->all())
            ->all();

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var Role $record */
        $ids = collect($data['permissions'] ?? [])->flatten()->filter()->unique()->values()->all();

        $record->syncPermissions($ids);

        return $record;
    }
}
