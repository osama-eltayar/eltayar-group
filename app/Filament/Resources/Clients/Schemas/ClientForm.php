<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Enums\ClientStatus;
use App\Enums\RoomType;
use App\Models\Client;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('client.singular_label'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name_en')
                            ->label(__('client.name_en'))
                            ->requiredWithout('name_ar')
                            ->maxLength(255),
                        TextInput::make('name_ar')
                            ->label(__('client.name_ar'))
                            ->requiredWithout('name_en')
                            ->maxLength(255),
                        TextInput::make('national_number')
                            ->label(__('client.national_number'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('passport_number')
                            ->label(__('client.passport_number'))
                            ->maxLength(255),
                        DatePicker::make('date_of_birth')
                            ->label(__('client.date_of_birth')),
                        Select::make('parent_id')
                            ->label(__('client.parent'))
                            ->relationship('parent', 'id')
                            ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->label(__('client.status'))
                            ->options(ClientStatus::toOptions())
                            ->default(ClientStatus::Active->value)
                            ->required(),
                        RichEditor::make('notes')
                            ->label(__('client.notes'))
                            ->columnSpanFull(),
                    ]),
                Section::make(__('client.trips'))
                    ->schema([
                        Repeater::make('tripClients')
                            ->relationship()
                            ->label(__('client.trips'))
                            ->defaultItems(0)
                            ->schema([
                                Select::make('trip_id')
                                    ->label(__('trip_client.trip'))
                                    ->relationship('trip', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->distinct()
                                    ->required(),
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
                            ->columns(2)
                            ->addActionLabel(__('client.trip'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
