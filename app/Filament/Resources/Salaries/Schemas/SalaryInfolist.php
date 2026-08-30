<?php

namespace App\Filament\Resources\Salaries\Schemas;

use App\Models\Salary;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class SalaryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label(__('salary.user')),
                TextEntry::make('amount')
                    ->label(__('salary.amount')),
                TextEntry::make('started_at')
                    ->label(__('salary.started_at'))
                    ->date(),
                TextEntry::make('ended_at')
                    ->label(__('salary.ended_at'))
                    ->date()
                    ->placeholder('—'),
                TextEntry::make('last_salary')
                    ->label(__('salary.last_salary'))
                    ->state(fn (Salary $record): ?int => $record->latestLog?->amount)
                    ->placeholder('—'),
                TextEntry::make('last_salary_paid_at')
                    ->label(__('salary.last_salary_paid_at'))
                    ->state(fn (Salary $record): ?Carbon => $record->latestLog?->paid_at)
                    ->date()
                    ->placeholder('—'),
                TextEntry::make('last_salary_for_month')
                    ->label(__('salary.last_salary_for_month'))
                    ->state(fn (Salary $record): ?string => $record->latestLog?->for_month
                        ?->locale(app()->getLocale())
                        ->translatedFormat('F Y'))
                    ->placeholder('—'),
            ]);
    }
}
