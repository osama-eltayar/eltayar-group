<?php

namespace App\Filament\Resources\HajClients\Tables;

use App\Enums\HajClientDependencyType;
use App\Enums\HajClientRelationType;
use App\Enums\HajClientStatus;
use App\Filament\Resources\Bookings\BookingResource;
use App\Filament\Resources\Clients\ClientResource;
use App\Filament\Resources\HajClients\HajClientResource;
use App\Filament\Resources\Hajs\HajResource;
use App\Models\Client;
use App\Models\HajClient;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HajClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (HajClient $record): string => HajClientResource::getUrl('view', ['record' => $record]))
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['client', 'haj', 'booking']))
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
                    ->url(fn (HajClient $record): ?string => $record->haj ? HajResource::getUrl('view', ['record' => $record->haj]) : null)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_id')
                    ->label(__('haj_client.booking'))
                    ->url(fn (HajClient $record): ?string => $record->booking ? BookingResource::getUrl('view', ['record' => $record->booking]) : null)
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('dependency_type')
                    ->label(__('haj_client.dependency_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('dependsOn.client.name')
                    ->label(__('haj_client.depends_on'))
                    ->url(fn (HajClient $record): ?string => $record->dependsOn ? HajClientResource::getUrl('view', ['record' => $record->dependsOn]) : null)
                    ->placeholder('—'),
                TextColumn::make('relation_type')
                    ->label(__('haj_client.relation_type'))
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('client.factory_number')
                    ->label(__('client.factory_number'))
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('client.passport_ended_at')
                    ->label(__('client.passport_ended_at'))
                    ->date()
                    ->badge()
                    ->color(fn (HajClient $record): ?string => $record->hasPassportBelowMinimum() ? 'danger' : 'gray')
                    ->icon(fn (HajClient $record): ?Heroicon => $record->hasPassportBelowMinimum() ? Heroicon::ExclamationTriangle : null)
                    ->tooltip(fn (HajClient $record): ?string => $record->hasPassportBelowMinimum() ? __('haj_client.passport_below_minimum') : null)
                    ->placeholder('—')
                    ->sortable(),
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
                Filter::make('passport_below_minimum')
                    ->label(__('haj_client.passport_below_minimum'))
                    ->baseQuery(fn (Builder $query): Builder => $query
                        ->join('clients', 'clients.id', '=', 'haj_clients.client_id')
                        ->join('hajs', 'hajs.id', '=', 'haj_clients.haj_id')
                        ->select('haj_clients.*'))
                    ->query(fn (Builder $query): Builder => $query
                        ->whereColumn('clients.passport_ended_at', '<', 'hajs.passport_minimum_end_at')),
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
                HajClientResource::markHajClientSuccessfulAction(),
                HajClientResource::markHajClientUnsuccessfulAction(),
                HajClientResource::markHajClientReserveAction(),
                HajClientResource::markHajClientWithdrawnAction(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
