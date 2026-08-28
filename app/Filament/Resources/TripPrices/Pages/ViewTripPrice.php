<?php

namespace App\Filament\Resources\TripPrices\Pages;

use App\Filament\Resources\TripPrices\TripPriceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTripPrice extends ViewRecord
{
    protected static string $resource = TripPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
