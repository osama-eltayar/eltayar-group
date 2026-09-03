<?php

namespace App\Filament\Resources\OmraPrices\Tables;

use App\Enums\RoomType;
use App\Filament\Resources\OmraPrices\OmraPriceResource;
use App\Models\OmraPrice;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OmraPricesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (OmraPrice $record): string => OmraPriceResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('omra.name')
                    ->label(__('omra_price.omra'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('room_type')
                    ->label(__('omra_price.room_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('omra_price.price'))
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('omra_price.is_active'))
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('omra')
                    ->label(__('omra_price.omra'))
                    ->relationship('omra', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('room_type')
                    ->label(__('omra_price.room_type'))
                    ->options(RoomType::toOptions()),
                TernaryFilter::make('is_active')
                    ->label(__('omra_price.is_active')),
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
