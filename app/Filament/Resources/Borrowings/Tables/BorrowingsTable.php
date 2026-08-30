<?php

namespace App\Filament\Resources\Borrowings\Tables;

use App\Filament\Resources\Borrowings\BorrowingResource;
use App\Models\Borrowing;
use App\Models\BorrowingLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class BorrowingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Borrowing $record): string => BorrowingResource::getUrl('view', ['record' => $record]))
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['user', 'latestLog']))
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('borrowing.user'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('borrowing.amount'))
                    ->sortable(),
                TextColumn::make('paid')
                    ->label(__('borrowing.paid'))
                    ->sortable(),
                TextColumn::make('remaining')
                    ->label(__('borrowing.remaining'))
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label(__('borrowing.paid_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('expected_at')
                    ->label(__('borrowing.expected_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('ended_at')
                    ->label(__('borrowing.ended_at'))
                    ->date()
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('last_amount_paid')
                    ->label(__('borrowing.last_amount_paid'))
                    ->state(fn (Borrowing $record): ?int => $record->latestLog?->amount)
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy(
                        BorrowingLog::select('amount')
                            ->whereColumn('borrowing_logs.borrowing_id', 'borrowings.id')
                            ->orderByDesc('paid_at')
                            ->limit(1),
                        $direction,
                    ))
                    ->placeholder('—'),
                TextColumn::make('last_amount_paid_date')
                    ->label(__('borrowing.last_amount_paid_date'))
                    ->state(fn (Borrowing $record): ?Carbon => $record->latestLog?->paid_at)
                    ->date()
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy(
                        BorrowingLog::select('paid_at')
                            ->whereColumn('borrowing_logs.borrowing_id', 'borrowings.id')
                            ->orderByDesc('paid_at')
                            ->limit(1),
                        $direction,
                    ))
                    ->placeholder('—'),
            ])
            ->filters([
                Filter::make('amount')
                    ->schema([
                        TextInput::make('amount_from')
                            ->label(__('borrowing.amount').' - '.__('borrowing.from'))
                            ->numeric(),
                        TextInput::make('amount_until')
                            ->label(__('borrowing.amount').' - '.__('borrowing.until'))
                            ->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['amount_from'] ?? null, fn (Builder $q, $value): Builder => $q->where('amount', '>=', $value))
                        ->when($data['amount_until'] ?? null, fn (Builder $q, $value): Builder => $q->where('amount', '<=', $value))),
                Filter::make('paid')
                    ->schema([
                        TextInput::make('paid_from')
                            ->label(__('borrowing.paid').' - '.__('borrowing.from'))
                            ->numeric(),
                        TextInput::make('paid_until')
                            ->label(__('borrowing.paid').' - '.__('borrowing.until'))
                            ->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['paid_from'] ?? null, fn (Builder $q, $value): Builder => $q->where('paid', '>=', $value))
                        ->when($data['paid_until'] ?? null, fn (Builder $q, $value): Builder => $q->where('paid', '<=', $value))),
                Filter::make('remaining')
                    ->schema([
                        TextInput::make('remaining_from')
                            ->label(__('borrowing.remaining').' - '.__('borrowing.from'))
                            ->numeric(),
                        TextInput::make('remaining_until')
                            ->label(__('borrowing.remaining').' - '.__('borrowing.until'))
                            ->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['remaining_from'] ?? null, fn (Builder $q, $value): Builder => $q->where('remaining', '>=', $value))
                        ->when($data['remaining_until'] ?? null, fn (Builder $q, $value): Builder => $q->where('remaining', '<=', $value))),
                Filter::make('paid_at')
                    ->schema([
                        DatePicker::make('paid_at_from')
                            ->label(__('borrowing.paid_at').' - '.__('borrowing.from')),
                        DatePicker::make('paid_at_until')
                            ->label(__('borrowing.paid_at').' - '.__('borrowing.until')),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['paid_at_from'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('paid_at', '>=', $date))
                        ->when($data['paid_at_until'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('paid_at', '<=', $date))),
                Filter::make('expected_at')
                    ->schema([
                        DatePicker::make('expected_at_from')
                            ->label(__('borrowing.expected_at').' - '.__('borrowing.from')),
                        DatePicker::make('expected_at_until')
                            ->label(__('borrowing.expected_at').' - '.__('borrowing.until')),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['expected_at_from'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('expected_at', '>=', $date))
                        ->when($data['expected_at_until'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('expected_at', '<=', $date))),
                Filter::make('ended_at')
                    ->schema([
                        DatePicker::make('ended_at_from')
                            ->label(__('borrowing.ended_at').' - '.__('borrowing.from')),
                        DatePicker::make('ended_at_until')
                            ->label(__('borrowing.ended_at').' - '.__('borrowing.until')),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['ended_at_from'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('ended_at', '>=', $date))
                        ->when($data['ended_at_until'] ?? null, fn (Builder $q, $date): Builder => $q->whereDate('ended_at', '<=', $date))),
                Filter::make('last_amount_paid')
                    ->schema([
                        TextInput::make('last_amount_paid_from')
                            ->label(__('borrowing.last_amount_paid').' - '.__('borrowing.from'))
                            ->numeric(),
                        TextInput::make('last_amount_paid_until')
                            ->label(__('borrowing.last_amount_paid').' - '.__('borrowing.until'))
                            ->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['last_amount_paid_from'] ?? null, fn (Builder $q, $value): Builder => $q->whereHas('latestLog', fn (Builder $q2): Builder => $q2->where('amount', '>=', $value)))
                        ->when($data['last_amount_paid_until'] ?? null, fn (Builder $q, $value): Builder => $q->whereHas('latestLog', fn (Builder $q2): Builder => $q2->where('amount', '<=', $value)))),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn (Borrowing $record): bool => $record->logs()->doesntExist()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
