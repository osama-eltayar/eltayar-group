<?php

namespace App\Filament\Resources\HajClients\Schemas;

use App\Filament\Resources\Bookings\BookingResource;
use App\Filament\Resources\Clients\ClientResource;
use App\Filament\Resources\HajClients\HajClientResource;
use App\Filament\Resources\Hajs\HajResource;
use App\Models\HajClient;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class HajClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('client.singular_label'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('client.name')
                            ->label(__('haj_client.client'))
                            ->url(fn (HajClient $record): ?string => $record->client ? ClientResource::getUrl('view', ['record' => $record->client]) : null),
                        TextEntry::make('client.national_number')
                            ->label(__('client.national_number')),
                        TextEntry::make('client.passport_number')
                            ->label(__('client.passport_number'))
                            ->placeholder('—'),
                        TextEntry::make('client.factory_number')
                            ->label(__('client.factory_number'))
                            ->placeholder('—'),
                        TextEntry::make('client.passport_ended_at')
                            ->label(__('client.passport_ended_at'))
                            ->date()
                            ->badge()
                            ->color(fn (HajClient $record): ?string => $record->hasPassportBelowMinimum() ? 'danger' : 'gray')
                            ->icon(fn (HajClient $record): ?Heroicon => $record->hasPassportBelowMinimum() ? Heroicon::ExclamationTriangle : null)
                            ->tooltip(fn (HajClient $record): ?string => $record->hasPassportBelowMinimum() ? __('haj_client.passport_below_minimum') : null)
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
                Section::make(__('haj_client.singular_label'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('haj.name')
                            ->label(__('haj_client.haj'))
                            ->url(fn (HajClient $record): ?string => $record->haj ? HajResource::getUrl('view', ['record' => $record->haj]) : null),
                        TextEntry::make('booking_id')
                            ->label(__('haj_client.booking'))
                            ->url(fn (HajClient $record): ?string => $record->booking ? BookingResource::getUrl('view', ['record' => $record->booking]) : null)
                            ->placeholder('—'),
                        TextEntry::make('status')
                            ->label(__('haj_client.status'))
                            ->badge(),
                        TextEntry::make('dependency_type')
                            ->label(__('haj_client.dependency_type'))
                            ->badge(),
                        TextEntry::make('dependsOn.client.name')
                            ->label(__('haj_client.depends_on'))
                            ->url(fn (HajClient $record): ?string => $record->dependsOn ? HajClientResource::getUrl('view', ['record' => $record->dependsOn]) : null)
                            ->placeholder('—'),
                        TextEntry::make('relation_type')
                            ->label(__('haj_client.relation_type'))
                            ->badge()
                            ->placeholder('—'),
                        TextEntry::make('discount_amount')
                            ->label(__('haj_client.discount_amount')),
                        TextEntry::make('notes')
                            ->label(__('haj_client.notes'))
                            ->html()
                            ->columnSpanFull()
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
