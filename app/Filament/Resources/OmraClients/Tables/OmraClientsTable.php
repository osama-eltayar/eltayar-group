<?php

namespace App\Filament\Resources\OmraClients\Tables;

use App\Enums\RoomType;
use App\Filament\Resources\OmraClients\OmraClientResource;
use App\Models\Client;
use App\Models\OmraClient;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OmraClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (OmraClient $record): string => OmraClientResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('branch.name')
                    ->label(__('omra_client.branch'))
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label(__('omra_client.client'))
                    ->searchable(),
                TextColumn::make('omra.name')
                    ->label(__('omra_client.omra'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_id')
                    ->label(__('omra_client.booking'))
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('room_type')
                    ->label(__('omra_client.room_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('omra_client.price'))
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->label(__('omra_client.discount_amount')),
                TextColumn::make('final_price')
                    ->label(__('omra_client.final_price'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('branch')
                    ->label(__('omra_client.branch'))
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('omra')
                    ->label(__('omra_client.omra'))
                    ->relationship('omra', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('client_id')
                    ->label(__('omra_client.client'))
                    ->options(fn (): array => Client::query()
                        ->get()
                        ->mapWithKeys(fn (Client $client): array => [$client->id => $client->name])
                        ->all())
                    ->multiple()
                    ->searchable(),
                SelectFilter::make('room_type')
                    ->label(__('omra_client.room_type'))
                    ->options(RoomType::toOptions())
                    ->multiple(),
                Filter::make('price')
                    ->schema([
                        Fieldset::make(__('omra_client.price'))
                            ->columns(2)
                            ->schema([
                                TextInput::make('price_from')
                                    ->label(__('omra_client.from'))
                                    ->numeric()
                                    ->minValue(0),
                                TextInput::make('price_until')
                                    ->label(__('omra_client.until'))
                                    ->numeric()
                                    ->minValue(0),
                            ]),
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
