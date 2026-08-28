<?php

namespace App\Filament\Resources\TripClients\Pages;

use App\Filament\Resources\TripClients\TripClientResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTripClient extends ViewRecord
{
    protected static string $resource = TripClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
