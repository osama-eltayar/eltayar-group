<?php

namespace App\Filament\Resources\TripPrices\Pages;

use App\Filament\Resources\TripPrices\TripPriceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTripPrice extends EditRecord
{
    protected static string $resource = TripPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
