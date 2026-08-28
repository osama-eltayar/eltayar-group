<?php

namespace App\Filament\Resources\ClientServices\Schemas;

use App\Enums\ClientServiceStatus;
use App\Models\Client;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label(__('client_service.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('service_name')
                    ->label(__('client_service.service_name'))
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('service_date')
                    ->label(__('client_service.service_date')),
                TextInput::make('amount')
                    ->label(__('client_service.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Select::make('status')
                    ->label(__('client_service.status'))
                    ->options(ClientServiceStatus::toOptions())
                    ->default(ClientServiceStatus::Pending->value)
                    ->required(),
                RichEditor::make('notes')
                    ->label(__('client_service.notes'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
