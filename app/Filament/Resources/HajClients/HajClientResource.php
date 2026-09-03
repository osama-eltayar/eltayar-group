<?php

namespace App\Filament\Resources\HajClients;

use App\Enums\HajClientStatus;
use App\Filament\Resources\HajClients\Pages\CreateHajClient;
use App\Filament\Resources\HajClients\Pages\EditHajClient;
use App\Filament\Resources\HajClients\Pages\ListHajClients;
use App\Filament\Resources\HajClients\Pages\ViewHajClient;
use App\Filament\Resources\HajClients\Schemas\HajClientForm;
use App\Filament\Resources\HajClients\Schemas\HajClientInfolist;
use App\Filament\Resources\HajClients\Tables\HajClientsTable;
use App\Models\HajClient;
use App\Services\HajClient\ChooseHajClientService;
use App\Services\HajClient\MarkHajClientPendingService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HajClientResource extends Resource
{
    protected static ?string $model = HajClient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('haj_client.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('haj_client.label');
    }

    public static function chooseHajClientAction(): Action
    {
        return Action::make('choose')
            ->label(__('haj_client.choose'))
            ->icon(Heroicon::CheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->authorize('choose')
            ->visible(fn (HajClient $record): bool => $record->status === HajClientStatus::Pending)
            ->action(fn (HajClient $record) => app(ChooseHajClientService::class)->execute($record));
    }

    public static function markHajClientPendingAction(): Action
    {
        return Action::make('markPending')
            ->label(__('haj_client.mark_pending'))
            ->icon(Heroicon::Clock)
            ->color('gray')
            ->requiresConfirmation()
            ->authorize('markPending')
            ->visible(fn (HajClient $record): bool => $record->status === HajClientStatus::Chosen)
            ->action(fn (HajClient $record) => app(MarkHajClientPendingService::class)->execute($record));
    }

    public static function form(Schema $schema): Schema
    {
        return HajClientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HajClientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HajClientsTable::configure($table);
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
            'index' => ListHajClients::route('/'),
            'create' => CreateHajClient::route('/create'),
            'view' => ViewHajClient::route('/{record}'),
            'edit' => EditHajClient::route('/{record}/edit'),
        ];
    }
}
