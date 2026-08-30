<?php

namespace App\Filament\Resources\Borrowings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BorrowingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label(__('borrowing.user')),
                TextEntry::make('amount')
                    ->label(__('borrowing.amount')),
                TextEntry::make('paid')
                    ->label(__('borrowing.paid')),
                TextEntry::make('remaining')
                    ->label(__('borrowing.remaining')),
                TextEntry::make('paid_at')
                    ->label(__('borrowing.paid_at'))
                    ->date(),
                TextEntry::make('expected_at')
                    ->label(__('borrowing.expected_at'))
                    ->date(),
                TextEntry::make('ended_at')
                    ->label(__('borrowing.ended_at'))
                    ->date()
                    ->placeholder('—'),
                TextEntry::make('notes')
                    ->label(__('borrowing.notes'))
                    ->html()
                    ->placeholder('—')
                    ->columnSpanFull(),
            ]);
    }
}
