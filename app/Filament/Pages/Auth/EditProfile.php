<?php

namespace App\Filament\Pages\Auth;

use DateTimeZone;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getTimezoneFormComponent(),
            ]);
    }

    protected function getTimezoneFormComponent(): Component
    {
        return Select::make('timezone')
            ->label(__('user.timezone'))
            ->options(collect(DateTimeZone::listIdentifiers())->mapWithKeys(
                fn (string $timezone): array => [$timezone => $timezone],
            ))
            ->searchable()
            ->native(false)
            ->placeholder(config('app.display_timezone'));
    }
}
