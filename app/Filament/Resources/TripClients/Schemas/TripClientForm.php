<?php

namespace App\Filament\Resources\TripClients\Schemas;

use App\Enums\RoomType;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TripClientForm
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
                Select::make('booking_id')
                    ->label(__('trip_client.booking'))
                    ->relationship('booking', 'id')
                    ->searchable()
                    ->preload(),
                Select::make('room_type')
                    ->label(__('trip_client.room_type'))
                    ->options(RoomType::toOptions())
                    ->default(RoomType::Default->value)
                    ->required(),
                TextInput::make('price')
                    ->label(__('trip_client.price'))
                    ->numeric()
                    ->minValue(0),
                TextInput::make('discount_amount')
                    ->label(__('trip_client.discount_amount'))
                    ->numeric()
                    ->minValue(0),
                TextInput::make('notes')
                    ->label(__('trip_client.notes'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
