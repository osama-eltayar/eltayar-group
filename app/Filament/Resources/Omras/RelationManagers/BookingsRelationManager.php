<?php

namespace App\Filament\Resources\Omras\RelationManagers;

use App\Enums\RoomType;
use App\Models\Client;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label(__('omra_client.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
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
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                TextInput::make('number_of_clients')
                    ->label(__('booking.number_of_clients'))
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                TextInput::make('paid')
                    ->label(__('booking.paid'))
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('client.name')
                    ->label(__('omra_client.client'))
                    ->searchable(),
                TextColumn::make('room_type')
                    ->label(__('booking.room_type'))
                    ->badge(),
                TextColumn::make('number_of_clients')
                    ->label(__('booking.number_of_clients')),
                TextColumn::make('total_price')
                    ->label(__('booking.total_price')),
                TextColumn::make('final_price')
                    ->label(__('booking.final_price')),
                TextColumn::make('paid')
                    ->label(__('booking.paid')),
                TextColumn::make('balance')
                    ->label(__('booking.balance')),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
