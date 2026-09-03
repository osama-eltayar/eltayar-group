<?php

namespace App\Filament\Resources\HajClients\Pages;

use App\Filament\Resources\HajClients\HajClientResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHajClient extends ViewRecord
{
    protected static string $resource = HajClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            HajClientResource::markHajClientSuccessfulAction(),
            HajClientResource::markHajClientUnsuccessfulAction(),
            HajClientResource::markHajClientReserveAction(),
            HajClientResource::markHajClientWithdrawnAction(),
            EditAction::make(),
        ];
    }
}
