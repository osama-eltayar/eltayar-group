<?php

namespace App\Filament\Resources\OmraClients\Schemas;

use App\Enums\RoomType;
use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Omra;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OmraClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->label(__('omra_client.branch'))
                    ->relationship('branch', 'name')
                    ->default(fn (): ?int => session('branch_id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('client_id')
                    ->label(__('omra_client.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm(ClientForm::quickCreateSchema()),
                Select::make('omra_id')
                    ->label(__('omra_client.omra'))
                    ->relationship('omra', 'name')
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('booking_id', null))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('booking_id')
                    ->label(__('omra_client.booking'))
                    ->options(fn (Get $get): array => Booking::query()
                        ->where('bookable_type', Omra::class)
                        ->where('bookable_id', $get('omra_id'))
                        ->pluck('id', 'id')
                        ->all())
                    ->searchable()
                    ->preload(),
                Select::make('room_type')
                    ->label(__('omra_client.room_type'))
                    ->options(RoomType::toOptions())
                    ->default(RoomType::Default->value)
                    ->required(),
                TextInput::make('price')
                    ->label(__('omra_client.price'))
                    ->numeric()
                    ->minValue(0),
                TextInput::make('discount_amount')
                    ->label(__('omra_client.discount_amount'))
                    ->numeric()
                    ->minValue(0),
                RichEditor::make('notes')
                    ->label(__('omra_client.notes'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
