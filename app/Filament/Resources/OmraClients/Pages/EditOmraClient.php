<?php

namespace App\Filament\Resources\OmraClients\Pages;

use App\Filament\Resources\OmraClients\OmraClientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOmraClient extends EditRecord
{
    protected static string $resource = OmraClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
