<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Enums\ClientStatus;
use App\Enums\RoomType;
use App\Models\Client;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class ClientForm
{
    /**
     * @return array<int, Component>
     */
    public static function quickCreateSchema(): array
    {
        return [
            Hidden::make('branch_id')
                ->default(fn (): ?int => session('branch_id')),
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
                ->unique()
                ->maxLength(255),
            TextInput::make('passport_number')
                ->label(__('client.passport_number'))
                ->maxLength(255),
            TextInput::make('factory_number')
                ->label(__('client.factory_number'))
                ->maxLength(255),
            DatePicker::make('passport_ended_at')
                ->label(__('client.passport_ended_at')),
            DatePicker::make('date_of_birth')
                ->label(__('client.date_of_birth')),
            Select::make('status')
                ->label(__('client.status'))
                ->options(ClientStatus::toOptions())
                ->default(ClientStatus::Active->value)
                ->required(),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('client.singular_label'))
                    ->columns(2)
                    ->schema([
                        Select::make('branch_id')
                            ->label(__('client.branch'))
                            ->relationship('branch', 'name')
                            ->default(fn (): ?int => session('branch_id'))
                            ->searchable()
                            ->preload()
                            ->required(),
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
                        TextInput::make('factory_number')
                            ->label(__('client.factory_number'))
                            ->maxLength(255),
                        DatePicker::make('passport_ended_at')
                            ->label(__('client.passport_ended_at')),
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
                Section::make(__('client.phones'))
                    ->schema([
                        Repeater::make('phones')
                            ->relationship()
                            ->label(__('client.phones'))
                            ->defaultItems(0)
                            ->schema([
                                PhoneInput::make('phone')
                                    ->label(__('client.phone'))
                                    ->defaultCountry('EG')
                                    ->required(),
                                Toggle::make('is_default')
                                    ->label(__('client.is_default_phone'))
                                    ->fixIndistinctState(),
                            ])
                            ->columns(2)
                            ->addActionLabel(__('client.phone'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                Section::make(__('client.omras'))
                    ->schema([
                        Repeater::make('omraClients')
                            ->relationship()
                            ->label(__('client.omras'))
                            ->defaultItems(0)
                            ->schema([
                                Hidden::make('branch_id')
                                    ->default(fn (): ?int => session('branch_id')),
                                Select::make('omra_id')
                                    ->label(__('omra_client.omra'))
                                    ->relationship('omra', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->distinct()
                                    ->required(),
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
                            ->columns(2)
                            ->addActionLabel(__('client.omra'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
