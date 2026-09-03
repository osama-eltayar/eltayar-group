<?php

namespace App\Filament\Resources\HajClients;

use App\Enums\HajClientStatus;
use App\Filament\Resources\HajClients\Pages\CreateHajClient;
use App\Filament\Resources\HajClients\Pages\EditHajClient;
use App\Filament\Resources\HajClients\Pages\ListHajClients;
use App\Filament\Resources\HajClients\Pages\ViewHajClient;
use App\Filament\Resources\HajClients\RelationManagers\DependentsRelationManager;
use App\Filament\Resources\HajClients\Schemas\HajClientForm;
use App\Filament\Resources\HajClients\Schemas\HajClientInfolist;
use App\Filament\Resources\HajClients\Tables\HajClientsTable;
use App\Models\HajClient;
use App\Services\HajClient\MarkHajClientReserveService;
use App\Services\HajClient\MarkHajClientSuccessfulService;
use App\Services\HajClient\MarkHajClientUnsuccessfulService;
use App\Services\HajClient\MarkHajClientWithdrawnService;
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

    public static function markHajClientSuccessfulAction(): Action
    {
        return Action::make('markSuccessful')
            ->label(__('haj_client.mark_successful'))
            ->icon(Heroicon::CheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->authorize('markSuccessful')
            ->visible(fn (HajClient $record): bool => in_array($record->status, [HajClientStatus::NoShow, HajClientStatus::Reserve], true))
            ->action(fn (HajClient $record) => app(MarkHajClientSuccessfulService::class)->execute($record));
    }

    public static function markHajClientUnsuccessfulAction(): Action
    {
        return Action::make('markUnsuccessful')
            ->label(__('haj_client.mark_unsuccessful'))
            ->icon(Heroicon::XCircle)
            ->color('danger')
            ->requiresConfirmation()
            ->authorize('markUnsuccessful')
            ->visible(fn (HajClient $record): bool => $record->status === HajClientStatus::NoShow)
            ->action(fn (HajClient $record) => app(MarkHajClientUnsuccessfulService::class)->execute($record));
    }

    public static function markHajClientReserveAction(): Action
    {
        return Action::make('markReserve')
            ->label(__('haj_client.mark_reserve'))
            ->icon(Heroicon::Clock)
            ->color('gray')
            ->requiresConfirmation()
            ->authorize('markReserve')
            ->visible(fn (HajClient $record): bool => $record->status === HajClientStatus::NoShow)
            ->action(fn (HajClient $record) => app(MarkHajClientReserveService::class)->execute($record));
    }

    public static function markHajClientWithdrawnAction(): Action
    {
        return Action::make('markWithdrawn')
            ->label(__('haj_client.mark_withdrawn'))
            ->icon(Heroicon::ArrowUturnLeft)
            ->color('warning')
            ->requiresConfirmation()
            ->authorize('markWithdrawn')
            ->visible(fn (HajClient $record): bool => $record->status === HajClientStatus::Successful)
            ->action(fn (HajClient $record) => app(MarkHajClientWithdrawnService::class)->execute($record));
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
            DependentsRelationManager::class,
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
