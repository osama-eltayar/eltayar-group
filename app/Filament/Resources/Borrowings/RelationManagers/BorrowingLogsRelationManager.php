<?php

namespace App\Filament\Resources\Borrowings\RelationManagers;

use App\Models\Borrowing;
use App\Services\Borrowing\RecordBorrowingPaymentService;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BorrowingLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label(__('borrowing_log.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(fn (): int => $this->getOwnerRecord()->remaining)
                    ->required(),
                DatePicker::make('paid_at')
                    ->label(__('borrowing_log.paid_at'))
                    ->default(now())
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                TextColumn::make('amount')
                    ->label(__('borrowing_log.amount'))
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label(__('borrowing_log.paid_at'))
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('paid_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->visible(fn (): bool => $this->canLogPayment())
                    ->mutateFormDataUsing(function (array $data): array {
                        /** @var Borrowing $borrowing */
                        $borrowing = $this->getOwnerRecord();

                        app(RecordBorrowingPaymentService::class)->execute($borrowing, (int) $data['amount']);

                        return $data;
                    }),
            ]);
    }

    protected function canLogPayment(): bool
    {
        /** @var Borrowing $borrowing */
        $borrowing = $this->getOwnerRecord();

        return $borrowing->ended_at === null && $borrowing->remaining > 0;
    }
}
