<?php

namespace App\Filament\Resources\Salaries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SalaryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('salary.user'))
                    ->relationship('user', 'name', modifyQueryUsing: fn (Builder $query): Builder => $query->where('has_salary', true))
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('amount')
                    ->label(__('salary.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                DatePicker::make('started_at')
                    ->label(__('salary.started_at'))
                    ->default(now())
                    ->required(),
            ]);
    }
}
