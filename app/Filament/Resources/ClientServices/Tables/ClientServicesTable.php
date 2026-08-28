<?php

namespace App\Filament\Resources\ClientServices\Tables;

use App\Enums\ClientServiceStatus;
use App\Filament\Resources\ClientServices\ClientServiceResource;
use App\Models\ClientService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (ClientService $record): string => ClientServiceResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('client.name')
                    ->label(__('client_service.client'))
                    ->searchable(),
                TextColumn::make('service_name')
                    ->label(__('client_service.service_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service_date')
                    ->label(__('client_service.service_date'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('client_service.amount'))
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('client_service.status'))
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('client_service.status'))
                    ->options(ClientServiceStatus::toOptions()),
            ])
            ->defaultSort('service_date', 'desc')
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
