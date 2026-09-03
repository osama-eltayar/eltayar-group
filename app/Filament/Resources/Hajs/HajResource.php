<?php

namespace App\Filament\Resources\Hajs;

use App\Filament\Resources\Hajs\Pages\CreateHaj;
use App\Filament\Resources\Hajs\Pages\EditHaj;
use App\Filament\Resources\Hajs\Pages\ListHajs;
use App\Filament\Resources\Hajs\Pages\ViewHaj;
use App\Filament\Resources\Hajs\RelationManagers\BookingsRelationManager;
use App\Filament\Resources\Hajs\RelationManagers\HajClientsRelationManager;
use App\Filament\Resources\Hajs\Schemas\HajForm;
use App\Filament\Resources\Hajs\Tables\HajsTable;
use App\Models\Haj;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HajResource extends Resource
{
    protected static ?string $model = Haj::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('haj.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('haj.label');
    }

    public static function form(Schema $schema): Schema
    {
        return HajForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HajsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            HajClientsRelationManager::class,
            BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHajs::route('/'),
            'create' => CreateHaj::route('/create'),
            'view' => ViewHaj::route('/{record}'),
            'edit' => EditHaj::route('/{record}/edit'),
        ];
    }
}
