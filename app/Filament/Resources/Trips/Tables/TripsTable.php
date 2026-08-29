<?php

namespace App\Filament\Resources\Trips\Tables;

use App\Enums\TripActivity;
use App\Enums\TripStatus;
use App\Enums\TripType;
use App\Filament\Resources\Trips\TripResource;
use App\Models\Trip;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TripsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Trip $record): string => TripResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('name')
                    ->label(__('trip.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('trip.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('activity')
                    ->label(__('trip.activity'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('trip.type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label(__('trip.started_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('ended_at')
                    ->label(__('trip.ended_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('clients_count')
                    ->label(__('trip.clients_count'))
                    ->counts('clients')
                    ->sortable(),
                TextColumn::make('maximum_allowed')
                    ->label(__('trip.maximum_allowed'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('trip.status'))
                    ->options(TripStatus::toOptions()),
                SelectFilter::make('activity')
                    ->label(__('trip.activity'))
                    ->options(TripActivity::toOptions()),
                SelectFilter::make('type')
                    ->label(__('trip.type'))
                    ->options(TripType::toOptions()),
            ])
            ->defaultSort('started_at', 'desc')
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
