<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Support\PermissionLabel;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ManagePermissions extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return __('user.manage_permissions');
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
        /** @var User $record */
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
        /** @var User $record */
        $ids = collect($data['permissions'] ?? [])->flatten()->filter()->unique()->values()->all();

        $record->syncPermissions($ids);

        return $record;
    }
}
