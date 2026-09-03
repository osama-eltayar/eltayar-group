<?php

namespace App\Filament\Resources\Omras\Schemas;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OmraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('omra.name'))
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->label(__('omra.status'))
                    ->options(PackageStatus::toOptions())
                    ->default(PackageStatus::DRAFT->value)
                    ->required(),
                Select::make('type')
                    ->label(__('omra.type'))
                    ->options(PackageType::toOptions())
                    ->required(),
                DatePicker::make('started_at')
                    ->label(__('omra.started_at')),
                DatePicker::make('ended_at')
                    ->label(__('omra.ended_at'))
                    ->after('started_at'),
                TextInput::make('maximum_allowed')
                    ->label(__('omra.maximum_allowed'))
                    ->numeric()
                    ->minValue(0),
                RichEditor::make('description')
                    ->label(__('omra.description'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
