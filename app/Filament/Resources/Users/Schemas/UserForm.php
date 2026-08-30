<?php

namespace App\Filament\Resources\Users\Schemas;

use DateTimeZone;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
            ]);
    }
}
