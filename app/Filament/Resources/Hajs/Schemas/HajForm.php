<?php

namespace App\Filament\Resources\Hajs\Schemas;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HajForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('haj.name'))
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->label(__('haj.status'))
                    ->options(PackageStatus::toOptions())
                    ->default(PackageStatus::DRAFT->value)
                    ->required(),
                Select::make('type')
                    ->label(__('haj.type'))
                    ->options(PackageType::toOptions())
                    ->required(),
                TextInput::make('deposit_price')
                    ->label(__('haj.deposit_price'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                TextInput::make('full_price')
                    ->label(__('haj.full_price'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                TextInput::make('maximum_allowed')
                    ->label(__('haj.maximum_allowed'))
                    ->numeric()
                    ->minValue(0),
                DatePicker::make('passport_minimum_end_at')
                    ->label(__('haj.passport_minimum_end_at')),
                RichEditor::make('description')
                    ->label(__('haj.description'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
