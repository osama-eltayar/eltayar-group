<?php

namespace App\Filament\Resources\TripClients\Pages;

use App\Filament\Resources\TripClients\TripClientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTripClient extends EditRecord
{
    protected static string $resource = TripClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
