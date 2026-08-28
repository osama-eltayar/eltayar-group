<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use App\Models\Client;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientsRelationManager extends RelationManager
{
    protected static string $relationship = 'clients';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('national_number')
            ->columns([
                TextColumn::make('name')
                    ->label(__('client.singular_label'))
                    ->state(fn (Client $record): string => $record->name)
                    ->searchable(['name_en', 'name_ar']),
                TextColumn::make('national_number')
                    ->label(__('client.national_number'))
                    ->searchable(),
                TextColumn::make('room_type')
                    ->label(__('trip_client.room_type'))
                    ->badge(),
                TextColumn::make('final_price')
                    ->label(__('trip_client.final_price')),
            ])
            ->headerActions([
                AttachAction::make(),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
