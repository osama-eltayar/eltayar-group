<?php

namespace App\Filament\Resources\Omras\Tables;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use App\Filament\Resources\Omras\OmraResource;
use App\Models\Omra;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OmrasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Omra $record): string => OmraResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('name')
                    ->label(__('omra.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('omra.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('omra.type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label(__('omra.started_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('ended_at')
                    ->label(__('omra.ended_at'))
                    ->date()
                    ->sortable(),
                TextColumn::make('clients_count')
                    ->label(__('omra.clients_count'))
                    ->counts('clients')
                    ->sortable(),
                TextColumn::make('maximum_allowed')
                    ->label(__('omra.maximum_allowed'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('omra.status'))
                    ->options(PackageStatus::toOptions()),
                SelectFilter::make('type')
                    ->label(__('omra.type'))
                    ->options(PackageType::toOptions()),
            ])
            ->defaultSort('started_at', 'desc')
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
