<?php

namespace App\Filament\Resources\Borrowings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BorrowingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('borrowing.user'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('amount')
                    ->label(__('borrowing.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                DatePicker::make('paid_at')
                    ->label(__('borrowing.paid_at'))
                    ->default(now())
                    ->required(),
                DatePicker::make('expected_at')
                    ->label(__('borrowing.expected_at'))
                    ->required(),
                RichEditor::make('notes')
                    ->label(__('borrowing.notes'))
                    ->columnSpanFull(),
            ]);
    }
}
