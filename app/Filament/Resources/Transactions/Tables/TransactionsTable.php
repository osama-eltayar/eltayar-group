<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Filament\Resources\Transactions\TransactionResource;
use App\Models\Client;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Fieldset;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Transaction $record): string => TransactionResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('identifier')
                    ->label(__('transaction.identifier'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('branch.name')
                    ->label(__('transaction.branch'))
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label(__('transaction.client'))
                    ->searchable(),
                TextColumn::make('about')
                    ->label(__('transaction.about'))
                    ->searchable(),
                TextColumn::make('amount')
                    ->label(__('transaction.amount'))
                    ->sortable(),
                TextColumn::make('currency_code')
                    ->label(__('transaction.currency'))
                    ->badge(),
                TextColumn::make('type')
                    ->label(__('transaction.type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label(__('transaction.payment_method')),
                TextColumn::make('reviewer.name')
                    ->label(__('transaction.reviewed_by'))
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('branch')
                    ->label(__('transaction.branch'))
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('type')
                    ->label(__('transaction.type'))
                    ->options(TransactionType::toOptions()),
                SelectFilter::make('currency_code')
                    ->label(__('transaction.currency'))
                    ->options(Currency::toOptions()),
                SelectFilter::make('payment_method')
                    ->label(__('transaction.payment_method'))
                    ->options(PaymentMethod::toOptions()),
                SelectFilter::make('user_id')
                    ->label(__('transaction.user'))
                    ->relationship('user', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('client_id')
                    ->label(__('transaction.client'))
                    ->options(fn (): array => Client::query()
                        ->get()
                        ->mapWithKeys(fn (Client $client): array => [$client->id => $client->name])
                        ->all())
                    ->multiple()
                    ->searchable(),
                TernaryFilter::make('reviewed_by')
                    ->label(__('transaction.reviewed_by'))
                    ->nullable(),
                Filter::make('created_at')
                    ->schema([
                        Fieldset::make(__('transaction.created_at'))
                            ->columns(2)
                            ->schema([
                                DateTimePicker::make('created_from')
                                    ->label(__('transaction.from')),
                                DateTimePicker::make('created_until')
                                    ->label(__('transaction.until')),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->where('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->where('created_at', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('markAsReviewed')
                    ->label(__('transaction.reviewed_by'))
                    ->icon(Heroicon::CheckCircle)
                    ->color('success')
                    ->visible(fn (Transaction $record): bool => ! $record->isReviewed())
                    ->requiresConfirmation()
                    ->action(fn (Transaction $record) => $record->update(['reviewed_by' => auth()->id()])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markAsReviewed')
                        ->label(__('transaction.reviewed_by'))
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['reviewed_by' => auth()->id()])),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
