<?php

namespace App\Filament\Resources\OmraPrices;

use App\Filament\Resources\OmraPrices\Pages\CreateOmraPrice;
use App\Filament\Resources\OmraPrices\Pages\EditOmraPrice;
use App\Filament\Resources\OmraPrices\Pages\ListOmraPrices;
use App\Filament\Resources\OmraPrices\Pages\ViewOmraPrice;
use App\Filament\Resources\OmraPrices\Schemas\OmraPriceForm;
use App\Filament\Resources\OmraPrices\Tables\OmraPricesTable;
use App\Models\OmraPrice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OmraPriceResource extends Resource
{
    protected static ?string $model = OmraPrice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string
    {
        return __('omra_price.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('omra_price.label');
    }

    public static function form(Schema $schema): Schema
    {
        return OmraPriceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OmraPricesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOmraPrices::route('/'),
            'create' => CreateOmraPrice::route('/create'),
            'view' => ViewOmraPrice::route('/{record}'),
            'edit' => EditOmraPrice::route('/{record}/edit'),
        ];
    }
}
