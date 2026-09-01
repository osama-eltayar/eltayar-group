<?php

namespace App\Filament\Resources\Salaries\Tables;

use App\Filament\Resources\Salaries\SalaryResource;
use App\Models\Salary;
use App\Models\SalaryLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class SalariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Salary $record): string => SalaryResource::getUrl('view', ['record' => $record]))
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['user', 'latestLog']))
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('salary.user'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('salary.amount'))
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label(__('salary.started_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('ended_at')
                    ->label(__('salary.ended_at'))
                    ->date()
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('last_salary')
                    ->label(__('salary.last_salary'))
                    ->state(fn (Salary $record): ?int => $record->latestLog?->amount)
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy(
                        SalaryLog::select('amount')
                            ->whereColumn('salary_logs.salary_id', 'salaries.id')
                            ->orderByDesc('paid_at')
                            ->limit(1),
                        $direction,
                    ))
                    ->placeholder('—'),
                TextColumn::make('last_salary_paid_at')
                    ->label(__('salary.last_salary_paid_at'))
                    ->state(fn (Salary $record): ?Carbon => $record->latestLog?->paid_at)
                    ->date()
                    ->placeholder('—'),
                TextColumn::make('last_salary_for_month')
                    ->label(__('salary.last_salary_for_month'))
                    ->state(fn (Salary $record): ?string => $record->latestLog?->for_month
                        ?->locale(app()->getLocale())
                        ->translatedFormat('F Y'))
                    ->placeholder('—'),
            ])
            ->filters([
                Filter::make('amount')
                    ->schema([
                        Fieldset::make(__('salary.amount'))
                            ->columns(2)
                            ->schema([
                                TextInput::make('amount_from')
                                    ->label(__('salary.from'))
                                    ->numeric(),
                                TextInput::make('amount_until')
                                    ->label(__('salary.until'))
                                    ->numeric(),
                            ]),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['amount_from'] ?? null, fn (Builder $q, $value): Builder => $q->where('amount', '>=', $value))
                        ->when($data['amount_until'] ?? null, fn (Builder $q, $value): Builder => $q->where('amount', '<=', $value))),
                Filter::make('started_at')
                    ->schema([
                        Fieldset::make(__('salary.started_at'))
                            ->columns(2)
                            ->schema([
                                DatePicker::make('started_from')
                                    ->label(__('salary.from')),
                                DatePicker::make('started_until')
                                    ->label(__('salary.until')),
                            ]),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['started_from'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('started_at', '>=', $date))
                        ->when($data['started_until'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('started_at', '<=', $date))),
                Filter::make('ended_at')
                    ->schema([
                        Fieldset::make(__('salary.ended_at'))
                            ->columns(2)
                            ->schema([
                                DatePicker::make('ended_from')
                                    ->label(__('salary.from')),
                                DatePicker::make('ended_until')
                                    ->label(__('salary.until')),
                            ]),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['ended_from'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('ended_at', '>=', $date))
                        ->when($data['ended_until'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('ended_at', '<=', $date))),
                Filter::make('last_salary')
                    ->schema([
                        Fieldset::make(__('salary.last_salary'))
                            ->columns(2)
                            ->schema([
                                TextInput::make('last_salary_from')
                                    ->label(__('salary.from'))
                                    ->numeric(),
                                TextInput::make('last_salary_until')
                                    ->label(__('salary.until'))
                                    ->numeric(),
                            ]),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['last_salary_from'] ?? null, fn (Builder $q, $value): Builder => $q->whereHas('latestLog', fn (Builder $q2): Builder => $q2->where('amount', '>=', $value)))
                        ->when($data['last_salary_until'] ?? null, fn (Builder $q, $value): Builder => $q->whereHas('latestLog', fn (Builder $q2): Builder => $q2->where('amount', '<=', $value)))),
            ])
            ->recordActions([
                SalaryResource::endSalaryAction(),
                EditAction::make()
                    ->visible(fn (Salary $record): bool => $record->logs()->doesntExist()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
