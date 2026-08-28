<?php

namespace App\Filament\Resources\TripPrices;

use App\Filament\Resources\TripPrices\Pages\CreateTripPrice;
use App\Filament\Resources\TripPrices\Pages\EditTripPrice;
use App\Filament\Resources\TripPrices\Pages\ListTripPrices;
use App\Filament\Resources\TripPrices\Pages\ViewTripPrice;
use App\Filament\Resources\TripPrices\Schemas\TripPriceForm;
use App\Filament\Resources\TripPrices\Tables\TripPricesTable;
use App\Models\TripPrice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TripPriceResource extends Resource
{
    protected static ?string $model = TripPrice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string
    {
        return __('trip_price.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('trip_price.label');
    }

    public static function form(Schema $schema): Schema
    {
        return TripPriceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TripPricesTable::configure($table);
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
            'index' => ListTripPrices::route('/'),
            'create' => CreateTripPrice::route('/create'),
            'view' => ViewTripPrice::route('/{record}'),
            'edit' => EditTripPrice::route('/{record}/edit'),
        ];
    }
}
