<?php

namespace App\Filament\Resources\TripClients;

use App\Filament\Resources\TripClients\Pages\CreateTripClient;
use App\Filament\Resources\TripClients\Pages\EditTripClient;
use App\Filament\Resources\TripClients\Pages\ListTripClients;
use App\Filament\Resources\TripClients\Pages\ViewTripClient;
use App\Filament\Resources\TripClients\Schemas\TripClientForm;
use App\Filament\Resources\TripClients\Tables\TripClientsTable;
use App\Models\TripClient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TripClientResource extends Resource
{
    protected static ?string $model = TripClient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('trip_client.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('trip_client.label');
    }

    public static function form(Schema $schema): Schema
    {
        return TripClientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TripClientsTable::configure($table);
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
            'index' => ListTripClients::route('/'),
            'create' => CreateTripClient::route('/create'),
            'view' => ViewTripClient::route('/{record}'),
            'edit' => EditTripClient::route('/{record}/edit'),
        ];
    }
}
