<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Enums\RoomType;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label(__('trip_client.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('trip_id')
                    ->label(__('trip_client.trip'))
                    ->relationship('trip', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('room_type')
                    ->label(__('booking.room_type'))
                    ->options(RoomType::toOptions())
                    ->default(RoomType::Default->value)
                    ->required(),
                TextInput::make('price')
                    ->label(__('booking.price'))
                    ->helperText(__('booking.price_per_client_hint'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                TextInput::make('number_of_clients')
                    ->label(__('booking.number_of_clients'))
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
                TextInput::make('paid')
                    ->label(__('booking.paid'))
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Section::make(__('booking.singular_label'))
                    ->columns(3)
                    ->hiddenOn('create')
                    ->schema([
                        TextInput::make('total_price')
                            ->label(__('booking.total_price'))
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('final_price')
                            ->label(__('booking.final_price'))
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('balance')
                            ->label(__('booking.balance'))
                            ->disabled()
                            ->dehydrated(false),
                    ]),
            ])
            ->columns(2);
    }
}
