<?php

namespace App\Filament\Resources\TripClients\Pages;

use App\Filament\Resources\TripClients\TripClientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTripClients extends ListRecords
{
    protected static string $resource = TripClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
