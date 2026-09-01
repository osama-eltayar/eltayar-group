<?php

namespace App\Filament\Resources\Borrowings;

use App\Filament\Resources\Borrowings\Pages\CreateBorrowing;
use App\Filament\Resources\Borrowings\Pages\EditBorrowing;
use App\Filament\Resources\Borrowings\Pages\ListBorrowings;
use App\Filament\Resources\Borrowings\Pages\ViewBorrowing;
use App\Filament\Resources\Borrowings\RelationManagers\BorrowingLogsRelationManager;
use App\Filament\Resources\Borrowings\Schemas\BorrowingForm;
use App\Filament\Resources\Borrowings\Schemas\BorrowingInfolist;
use App\Filament\Resources\Borrowings\Tables\BorrowingsTable;
use App\Models\Borrowing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BorrowingResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('borrowing.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('borrowing.label');
    }

    public static function form(Schema $schema): Schema
    {
        return BorrowingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BorrowingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BorrowingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            BorrowingLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBorrowings::route('/'),
            'create' => CreateBorrowing::route('/create'),
            'view' => ViewBorrowing::route('/{record}'),
            'edit' => EditBorrowing::route('/{record}/edit'),
        ];
    }
}
