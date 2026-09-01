<?php

namespace App\Filament\Resources\Roles\Tables;

use App\Filament\Resources\Roles\RoleResource;
use App\Filament\Support\RoleLabel;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Role $record): string => RoleResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('name')
                    ->label(__('role.name'))
                    ->formatStateUsing(fn (Role $record): string => RoleLabel::for($record))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('permissions_count')
                    ->label(__('role.permissions'))
                    ->counts('permissions')
                    ->badge(),
            ])
            ->defaultSort('name');
    }
}
