<?php

namespace App\Filament\Resources\Users\Schemas;

use DateTimeZone;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('user.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('user.email'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('roles')
                    ->label(__('user.roles'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Select::make('timezone')
                    ->label(__('user.timezone'))
                    ->options(collect(DateTimeZone::listIdentifiers())->mapWithKeys(
                        fn (string $timezone): array => [$timezone => $timezone],
                    ))
                    ->searchable()
                    ->native(false)
                    ->placeholder(config('app.display_timezone')),
                Toggle::make('has_salary')
                    ->label(__('user.has_salary'))
                    ->live()
                    ->default(false),
                Section::make(__('user.salary_details'))
                    ->visible(fn (Get $get, string $operation): bool => $operation === 'create' && $get('has_salary'))
                    ->components([
                        TextInput::make('salary.amount')
                            ->label(__('user.salary_amount'))
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        DatePicker::make('salary.started_at')
                            ->label(__('user.salary_started_at'))
                            ->default(now())
                            ->required(),
                    ]),
            ]);
    }
}
