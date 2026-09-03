<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Enums\RoomType;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OmrasRelationManager extends RelationManager
{
    protected static string $relationship = 'omras';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('omra.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('omra.status'))
                    ->badge(),
                TextColumn::make('room_type')
                    ->label(__('omra_client.room_type'))
                    ->badge(),
                TextColumn::make('price')
                    ->label(__('omra_client.price')),
                TextColumn::make('discount_amount')
                    ->label(__('omra_client.discount_amount')),
                TextColumn::make('final_price')
                    ->label(__('omra_client.final_price')),
            ])
            ->headerActions([
                AttachAction::make()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('room_type')
                            ->label(__('omra_client.room_type'))
                            ->options(RoomType::toOptions())
                            ->default(RoomType::Default->value)
                            ->required(),
                        TextInput::make('price')
                            ->label(__('omra_client.price'))
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('discount_amount')
                            ->label(__('omra_client.discount_amount'))
                            ->numeric()
                            ->minValue(0),
                    ]),
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
