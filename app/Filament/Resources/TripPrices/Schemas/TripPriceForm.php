<?php

namespace App\Filament\Resources\TripPrices\Schemas;

use App\Enums\RoomType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

class TripPriceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('trip_id')
                    ->label(__('trip_price.trip'))
                    ->relationship('trip', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                Select::make('room_type')
                    ->label(__('trip_price.room_type'))
                    ->options(RoomType::toOptions())
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: fn (Unique $rule, Get $get): Unique => $rule->where('trip_id', $get('trip_id')),
                    )
                    ->required(),
                TextInput::make('price')
                    ->label(__('trip_price.price'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('trip_price.is_active'))
                    ->default(true),
            ]);
    }
}
