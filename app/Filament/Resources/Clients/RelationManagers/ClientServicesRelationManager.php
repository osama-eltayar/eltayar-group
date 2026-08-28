<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Enums\ClientServiceStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'clientServices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('service_name')
                    ->label(__('client_service.service_name'))
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('service_date')
                    ->label(__('client_service.service_date')),
                TextInput::make('amount')
                    ->label(__('client_service.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Select::make('status')
                    ->label(__('client_service.status'))
                    ->options(ClientServiceStatus::toOptions())
                    ->default(ClientServiceStatus::Pending->value)
                    ->required(),
                RichEditor::make('notes')
                    ->label(__('client_service.notes'))
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_name')
            ->columns([
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
