<?php

namespace App\Filament\Resources\OmraClients;

use App\Filament\Resources\OmraClients\Pages\CreateOmraClient;
use App\Filament\Resources\OmraClients\Pages\EditOmraClient;
use App\Filament\Resources\OmraClients\Pages\ListOmraClients;
use App\Filament\Resources\OmraClients\Pages\ViewOmraClient;
use App\Filament\Resources\OmraClients\Schemas\OmraClientForm;
use App\Filament\Resources\OmraClients\Schemas\OmraClientInfolist;
use App\Filament\Resources\OmraClients\Tables\OmraClientsTable;
use App\Models\OmraClient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OmraClientResource extends Resource
{
    protected static ?string $model = OmraClient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.omra');
    }

    public static function getModelLabel(): string
    {
        return __('omra_client.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('omra_client.label');
    }

    public static function form(Schema $schema): Schema
    {
        return OmraClientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OmraClientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OmraClientsTable::configure($table);
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
            'index' => ListOmraClients::route('/'),
            'create' => CreateOmraClient::route('/create'),
            'view' => ViewOmraClient::route('/{record}'),
            'edit' => EditOmraClient::route('/{record}/edit'),
        ];
    }
}
