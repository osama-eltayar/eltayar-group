<?php

namespace App\Filament\Resources\OmraPrices\Schemas;

use App\Enums\RoomType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

class OmraPriceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('omra_id')
                    ->label(__('omra_price.omra'))
                    ->relationship('omra', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                Select::make('room_type')
                    ->label(__('omra_price.room_type'))
                    ->options(RoomType::toOptions())
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: fn (Unique $rule, Get $get): Unique => $rule->where('omra_id', $get('omra_id')),
                    )
                    ->required(),
                TextInput::make('price')
                    ->label(__('omra_price.price'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('omra_price.is_active'))
                    ->default(true),
            ]);
    }
}
