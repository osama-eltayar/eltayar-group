<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\Booking;
use App\Models\ClientService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MorphToSelect::make('transactionable')
                    ->label(__('transaction.transactionable'))
                    ->types([
                        MorphToSelect\Type::make(Booking::class)
                            ->titleAttribute('id'),
                        MorphToSelect\Type::make(ClientService::class)
                            ->titleAttribute('service_name'),
                    ]),
                TextInput::make('about')
                    ->label(__('transaction.about'))
                    ->maxLength(255),
                TextInput::make('delivered_by')
                    ->label(__('transaction.delivered_by'))
                    ->maxLength(255),
                TextInput::make('amount')
                    ->label(__('transaction.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Select::make('currency_code')
                    ->label(__('transaction.currency'))
                    ->options(Currency::toOptions())
                    ->default(Currency::EGYPTIAN_POUND->value)
                    ->required(),
                Select::make('payment_method')
                    ->label(__('transaction.payment_method'))
                    ->options(PaymentMethod::toOptions())
                    ->required(),
                Select::make('type')
                    ->label(__('transaction.type'))
                    ->options(TransactionType::toOptions())
                    ->required(),
                RichEditor::make('notes')
                    ->label(__('transaction.notes'))
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('about')
            ->columns([
                TextColumn::make('about')
                    ->label(__('transaction.about'))
                    ->searchable(),
                TextColumn::make('amount')
                    ->label(__('transaction.amount'))
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                TextColumn::make('currency_code')
                    ->label(__('transaction.currency'))
                    ->badge(),
                TextColumn::make('type')
                    ->label(__('transaction.type'))
                    ->badge(),
                TextColumn::make('payment_method')
                    ->label(__('transaction.payment_method')),
                TextColumn::make('reviewer.name')
                    ->label(__('transaction.reviewer'))
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('transaction.type'))
                    ->options(TransactionType::toOptions()),
                SelectFilter::make('currency_code')
                    ->label(__('transaction.currency'))
                    ->options(Currency::toOptions()),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
