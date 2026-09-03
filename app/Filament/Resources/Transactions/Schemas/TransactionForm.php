<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Models\Booking;
use App\Models\Client;
use App\Models\ClientService;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->label(__('transaction.branch'))
                    ->relationship('branch', 'name')
                    ->default(fn (): ?int => session('branch_id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('client_id')
                    ->label(__('transaction.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm(ClientForm::quickCreateSchema()),
                MorphToSelect::make('transactionable')
                    ->label(__('transaction.transactionable'))
                    ->types([
                        MorphToSelect\Type::make(Booking::class)
                            ->titleAttribute('id'),
                        MorphToSelect\Type::make(ClientService::class)
                            ->titleAttribute('service_name'),
                    ])
                    ->columnSpanFull(),
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
            ])
            ->columns(2);
    }
}
