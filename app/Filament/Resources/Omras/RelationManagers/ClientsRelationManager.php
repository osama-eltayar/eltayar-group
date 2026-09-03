<?php

namespace App\Filament\Resources\Omras\RelationManagers;

use App\Enums\RoomType;
use App\Models\Client;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientsRelationManager extends RelationManager
{
    protected static string $relationship = 'clients';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                RichEditor::make('notes')
                    ->label(__('omra_client.notes'))
                    ->columnSpanFull(),
            ]);
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
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
