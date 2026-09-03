<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use App\Enums\RoomType;
use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Omra;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class OmraClientsRelationManager extends RelationManager
{
    protected static string $relationship = 'omraClients';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->bookable_type === Omra::class;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label(__('omra_client.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm(ClientForm::quickCreateSchema()),
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
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('client.name')
                    ->label(__('omra_client.client'))
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
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        /** @var Booking $booking */
                        $booking = $this->getOwnerRecord();

                        $data['omra_id'] = $booking->bookable_id;
                        $data['branch_id'] = $booking->branch_id;

                        return $data;
                    }),
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
