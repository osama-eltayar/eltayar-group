<?php

namespace App\Filament\Resources\Omras;

use App\Filament\Resources\Omras\Pages\CreateOmra;
use App\Filament\Resources\Omras\Pages\EditOmra;
use App\Filament\Resources\Omras\Pages\ListOmras;
use App\Filament\Resources\Omras\Pages\ViewOmra;
use App\Filament\Resources\Omras\RelationManagers\BookingsRelationManager;
use App\Filament\Resources\Omras\RelationManagers\ClientsRelationManager;
use App\Filament\Resources\Omras\RelationManagers\OmraPricesRelationManager;
use App\Filament\Resources\Omras\Schemas\OmraForm;
use App\Filament\Resources\Omras\Tables\OmrasTable;
use App\Models\Omra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OmraResource extends Resource
{
    protected static ?string $model = Omra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('omra.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('omra.label');
    }

    public static function form(Schema $schema): Schema
    {
        return OmraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OmrasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ClientsRelationManager::class,
            OmraPricesRelationManager::class,
            BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOmras::route('/'),
            'create' => CreateOmra::route('/create'),
            'view' => ViewOmra::route('/{record}'),
            'edit' => EditOmra::route('/{record}/edit'),
        ];
    }
}
