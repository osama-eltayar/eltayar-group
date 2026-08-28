<?php

namespace App\Filament\Resources\TripClients\Tables;

use App\Enums\RoomType;
use App\Filament\Resources\TripClients\TripClientResource;
use App\Models\TripClient;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TripClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (TripClient $record): string => TripClientResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('client.name')
                    ->label(__('trip_client.client'))
                    ->searchable(),
                TextColumn::make('trip.name')
                    ->label(__('trip_client.trip'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_id')
                    ->label(__('trip_client.booking'))
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('room_type')
                    ->label(__('trip_client.room_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('trip_client.price'))
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->label(__('trip_client.discount_amount')),
                TextColumn::make('final_price')
                    ->label(__('trip_client.final_price'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('trip')
                    ->label(__('trip_client.trip'))
                    ->relationship('trip', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('room_type')
                    ->label(__('trip_client.room_type'))
                    ->options(RoomType::toOptions()),
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
