<?php

namespace App\Filament\Resources\OmraClients\Pages;

use App\Filament\Resources\OmraClients\OmraClientResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOmraClient extends ViewRecord
{
    protected static string $resource = OmraClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
