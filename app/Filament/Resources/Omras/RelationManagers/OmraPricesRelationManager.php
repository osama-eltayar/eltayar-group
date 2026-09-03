<?php

namespace App\Filament\Resources\Omras\RelationManagers;

use App\Enums\RoomType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class OmraPricesRelationManager extends RelationManager
{
    protected static string $relationship = 'omraPrices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('room_type')
                    ->label(__('omra_price.room_type'))
                    ->options(RoomType::toOptions())
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: fn (Unique $rule): Unique => $rule->where('omra_id', $this->getOwnerRecord()->getKey()),
                    )
                    ->required(),
                TextInput::make('price')
                    ->label(__('omra_price.price'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('omra_price.is_active'))
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('room_type')
            ->columns([
                TextColumn::make('room_type')
                    ->label(__('omra_price.room_type'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('omra_price.price'))
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('omra_price.is_active'))
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
