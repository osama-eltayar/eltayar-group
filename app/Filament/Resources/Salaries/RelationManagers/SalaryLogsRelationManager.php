<?php

namespace App\Filament\Resources\Salaries\RelationManagers;

use App\Models\SalaryLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class SalaryLogsRelationManager extends RelationManager
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
                    ->label(__('salary_log.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->default(fn (): int => $this->getOwnerRecord()->amount)
                    ->required(),
                DatePicker::make('paid_at')
                    ->label(__('salary_log.paid_at'))
                    ->default(now())
                    ->required(),
                TextInput::make('for_month')
                    ->label(__('salary_log.for_month'))
                    ->type('month')
                    ->default(now()->format('Y-m'))
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                TextColumn::make('amount')
                    ->label(__('salary_log.amount'))
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label(__('salary_log.paid_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('for_month')
                    ->label(__('salary_log.for_month'))
                    ->state(fn (SalaryLog $record): ?string => $record->for_month
                        ?->locale(app()->getLocale())
                        ->translatedFormat('F Y'))
                    ->sortable(),
            ])
            ->defaultSort('paid_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->visible(fn (): bool => $this->getOwnerRecord()->ended_at === null)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['for_month'] .= '-01';

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['for_month'] = Carbon::parse($data['for_month'])->format('Y-m');

                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['for_month'] .= '-01';

                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
