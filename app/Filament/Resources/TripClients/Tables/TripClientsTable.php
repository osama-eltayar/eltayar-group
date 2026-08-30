<?php

namespace App\Filament\Resources\TripClients\Tables;

use App\Enums\RoomType;
use App\Filament\Resources\TripClients\TripClientResource;
use App\Models\Client;
use App\Models\TripClient;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TripClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (TripClient $record): string => TripClientResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('branch.name')
                    ->label(__('trip_client.branch'))
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label(__('trip_client.client'))
                    ->searchable(),
                TextColumn::make('trip.name')
                    ->label(__('trip_client.trip'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_id')
                    ->label(__('trip_client.booking'))
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('room_type')
                    ->label(__('trip_client.room_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('trip_client.price'))
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->label(__('trip_client.discount_amount')),
                TextColumn::make('final_price')
                    ->label(__('trip_client.final_price'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('branch')
                    ->label(__('trip_client.branch'))
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('trip')
                    ->label(__('trip_client.trip'))
                    ->relationship('trip', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('client_id')
                    ->label(__('trip_client.client'))
                    ->options(fn (): array => Client::query()
                        ->get()
                        ->mapWithKeys(fn (Client $client): array => [$client->id => $client->name])
                        ->all())
                    ->multiple()
                    ->searchable(),
                SelectFilter::make('room_type')
                    ->label(__('trip_client.room_type'))
                    ->options(RoomType::toOptions())
                    ->multiple(),
                Filter::make('price')
                    ->label(__('trip_client.price'))
                    ->schema([
                        TextInput::make('price_from')
                            ->label(__('trip_client.price_from'))
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('price_until')
                            ->label(__('trip_client.price_until'))
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['price_from'] ?? null,
                                fn (Builder $query, $price): Builder => $query->where('price', '>=', $price),
                            )
                            ->when(
                                $data['price_until'] ?? null,
                                fn (Builder $query, $price): Builder => $query->where('price', '<=', $price),
                            );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
