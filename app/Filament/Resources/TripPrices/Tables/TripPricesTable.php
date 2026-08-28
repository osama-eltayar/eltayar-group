<?php

namespace App\Filament\Resources\TripPrices\Tables;

use App\Enums\RoomType;
use App\Filament\Resources\TripPrices\TripPriceResource;
use App\Models\TripPrice;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TripPricesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (TripPrice $record): string => TripPriceResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('trip.name')
                    ->label(__('trip_price.trip'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('room_type')
                    ->label(__('trip_price.room_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('trip_price.price'))
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('trip_price.is_active'))
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('trip')
                    ->label(__('trip_price.trip'))
                    ->relationship('trip', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('room_type')
                    ->label(__('trip_price.room_type'))
                    ->options(RoomType::toOptions()),
                TernaryFilter::make('is_active')
                    ->label(__('trip_price.is_active')),
            ])
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
