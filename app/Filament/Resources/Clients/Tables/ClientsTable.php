<?php

namespace App\Filament\Resources\Clients\Tables;

use App\Enums\ClientStatus;
use App\Filament\Resources\Clients\ClientResource;
use App\Models\Client;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Client $record): string => ClientResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('name_en')
                    ->label(__('client.name_en'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_ar')
                    ->label(__('client.name_ar'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('national_number')
                    ->label(__('client.national_number'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('passport_number')
                    ->label(__('client.passport_number'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_of_birth')
                    ->label(__('client.date_of_birth'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label(__('client.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('client.status'))
                    ->options(ClientStatus::toOptions()),
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
