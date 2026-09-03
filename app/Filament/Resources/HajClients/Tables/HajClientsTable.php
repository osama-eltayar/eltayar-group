<?php

namespace App\Filament\Resources\HajClients\Tables;

use App\Enums\HajClientDependencyType;
use App\Enums\HajClientRelationType;
use App\Enums\HajClientStatus;
use App\Filament\Resources\Clients\ClientResource;
use App\Filament\Resources\HajClients\HajClientResource;
use App\Models\Client;
use App\Models\HajClient;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HajClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (HajClient $record): string => HajClientResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('client.name')
                    ->label(__('haj_client.client'))
                    ->url(fn (HajClient $record): ?string => $record->client ? ClientResource::getUrl('view', ['record' => $record->client]) : null)
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('haj_client.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('haj.name')
                    ->label(__('haj_client.haj'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_id')
                    ->label(__('haj_client.booking'))
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('dependency_type')
                    ->label(__('haj_client.dependency_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('dependsOn.client.name')
                    ->label(__('haj_client.depends_on'))
                    ->placeholder('—'),
                TextColumn::make('relation_type')
                    ->label(__('haj_client.relation_type'))
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('discount_amount')
                    ->label(__('haj_client.discount_amount')),
            ])
            ->filters([
                SelectFilter::make('haj')
                    ->label(__('haj_client.haj'))
                    ->relationship('haj', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('client_id')
                    ->label(__('haj_client.client'))
                    ->options(fn (): array => Client::query()
                        ->get()
                        ->mapWithKeys(fn (Client $client): array => [$client->id => $client->name])
                        ->all())
                    ->multiple()
                    ->searchable(),
                SelectFilter::make('status')
                    ->label(__('haj_client.status'))
                    ->options(HajClientStatus::toOptions()),
                SelectFilter::make('dependency_type')
                    ->label(__('haj_client.dependency_type'))
                    ->options(HajClientDependencyType::toOptions()),
                SelectFilter::make('relation_type')
                    ->label(__('haj_client.relation_type'))
                    ->options(HajClientRelationType::toOptions()),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('applyDiscount')
                    ->label(__('haj_client.discount_amount'))
                    ->icon(Heroicon::Tag)
                    ->color('warning')
                    ->authorize('applyDiscount')
                    ->fillForm(fn (HajClient $record): array => [
                        'discount_amount' => $record->discount_amount,
                    ])
                    ->schema([
                        TextInput::make('discount_amount')
                            ->label(__('haj_client.discount_amount'))
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])
                    ->action(function (HajClient $record, array $data): void {
                        $record->update(['discount_amount' => $data['discount_amount']]);
                    }),
                HajClientResource::chooseHajClientAction(),
                HajClientResource::markHajClientPendingAction(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
