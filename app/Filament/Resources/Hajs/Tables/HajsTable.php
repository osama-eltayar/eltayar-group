<?php

namespace App\Filament\Resources\Hajs\Tables;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use App\Filament\Resources\Hajs\HajResource;
use App\Models\Haj;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HajsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Haj $record): string => HajResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('name')
                    ->label(__('haj.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('haj.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('haj.type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('deposit_price')
                    ->label(__('haj.deposit_price'))
                    ->sortable(),
                TextColumn::make('full_price')
                    ->label(__('haj.full_price'))
                    ->sortable(),
                TextColumn::make('haj_clients_count')
                    ->label(__('haj.clients_count'))
                    ->counts('hajClients')
                    ->sortable(),
                TextColumn::make('maximum_allowed')
                    ->label(__('haj.maximum_allowed'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('passport_minimum_end_at')
                    ->label(__('haj.passport_minimum_end_at'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('haj.status'))
                    ->options(PackageStatus::toOptions()),
                SelectFilter::make('type')
                    ->label(__('haj.type'))
                    ->options(PackageType::toOptions()),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
