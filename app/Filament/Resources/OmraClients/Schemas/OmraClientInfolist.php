<?php

namespace App\Filament\Resources\OmraClients\Schemas;

use App\Filament\Resources\Clients\ClientResource;
use App\Models\OmraClient;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OmraClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('client.singular_label'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('client.name')
                            ->label(__('omra_client.client'))
                            ->url(fn (OmraClient $record): ?string => $record->client ? ClientResource::getUrl('view', ['record' => $record->client]) : null),
                        TextEntry::make('client.national_number')
                            ->label(__('client.national_number')),
                        TextEntry::make('client.passport_number')
                            ->label(__('client.passport_number'))
                            ->placeholder('—'),
                        TextEntry::make('client.date_of_birth')
                            ->label(__('client.date_of_birth'))
                            ->date()
                            ->placeholder('—'),
                        TextEntry::make('client.status')
                            ->label(__('client.status'))
                            ->badge(),
                        TextEntry::make('client.branch.name')
                            ->label(__('client.branch'))
                            ->placeholder('—'),
                    ]),
                Section::make(__('omra_client.singular_label'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('branch.name')
                            ->label(__('omra_client.branch'))
                            ->placeholder('—'),
                        TextEntry::make('omra.name')
                            ->label(__('omra_client.omra')),
                        TextEntry::make('booking_id')
                            ->label(__('omra_client.booking'))
                            ->placeholder('—'),
                        TextEntry::make('room_type')
                            ->label(__('omra_client.room_type'))
                            ->badge(),
                        TextEntry::make('price')
                            ->label(__('omra_client.price')),
                        TextEntry::make('discount_amount')
                            ->label(__('omra_client.discount_amount')),
                        TextEntry::make('final_price')
                            ->label(__('omra_client.final_price')),
                        TextEntry::make('notes')
                            ->label(__('omra_client.notes'))
                            ->html()
                            ->columnSpanFull()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
