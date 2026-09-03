<?php

namespace App\Filament\Resources\HajClients\RelationManagers;

use App\Filament\Resources\HajClients\HajClientResource;
use App\Models\HajClient;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DependentsRelationManager extends RelationManager
{
    protected static string $relationship = 'dependents';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->heading(__('haj_client.dependents'))
            ->recordUrl(fn (HajClient $record): string => HajClientResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('client.name')
                    ->label(__('haj_client.client'))
                    ->searchable(),
                TextColumn::make('relation_type')
                    ->label(__('haj_client.relation_type'))
                    ->badge(),
                TextColumn::make('status')
                    ->label(__('haj_client.status'))
                    ->badge(),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
