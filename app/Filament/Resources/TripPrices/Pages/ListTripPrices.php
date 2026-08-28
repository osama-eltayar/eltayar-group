<?php

namespace App\Filament\Resources\TripPrices\Pages;

use App\Filament\Resources\TripPrices\TripPriceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTripPrices extends ListRecords
{
    protected static string $resource = TripPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
