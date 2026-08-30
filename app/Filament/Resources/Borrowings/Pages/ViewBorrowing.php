<?php

namespace App\Filament\Resources\Borrowings\Pages;

use App\Filament\Resources\Borrowings\BorrowingResource;
use App\Models\Borrowing;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBorrowing extends ViewRecord
{
    protected static string $resource = BorrowingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn (Borrowing $record): bool => BorrowingResource::canEdit($record)),
        ];
    }
}
