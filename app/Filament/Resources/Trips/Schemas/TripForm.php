<?php

namespace App\Filament\Resources\Trips\Schemas;

use App\Enums\TripActivity;
use App\Enums\TripStatus;
use App\Enums\TripType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TripForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('trip.name'))
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->label(__('trip.status'))
                    ->options(TripStatus::toOptions())
                    ->default(TripStatus::DRAFT->value)
                    ->required(),
                Select::make('activity')
                    ->label(__('trip.activity'))
                    ->options(TripActivity::toOptions())
                    ->required(),
                Select::make('type')
                    ->label(__('trip.type'))
                    ->options(TripType::toOptions())
                    ->required(),
                DatePicker::make('started_at')
                    ->label(__('trip.started_at')),
                DatePicker::make('ended_at')
                    ->label(__('trip.ended_at'))
                    ->after('started_at'),
                TextInput::make('maximum_allowed')
                    ->label(__('trip.maximum_allowed'))
                    ->numeric()
                    ->minValue(0),
                RichEditor::make('description')
                    ->label(__('trip.description'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
