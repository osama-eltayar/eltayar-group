<?php

namespace App\Filament\Resources\Permissions\Tables;

use App\Filament\Resources\Permissions\PermissionResource;
use App\Filament\Support\PermissionLabel;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;

class PermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Permission $record): string => PermissionResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('group')
                    ->label(__('permission.group'))
                    ->formatStateUsing(fn (string $state): string => PermissionLabel::group($state))
                    ->badge()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('permission.name'))
                    ->formatStateUsing(fn (Permission $record): string => PermissionLabel::for($record))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles_count')
                    ->label(__('permission.roles'))
                    ->counts('roles')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label(__('permission.group'))
                    ->options(fn (): array => Permission::query()->distinct()->pluck('group', 'group')->all()),
            ])
            ->defaultSort('group');
    }
}
