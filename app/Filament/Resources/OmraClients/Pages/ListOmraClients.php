<?php

namespace App\Filament\Resources\OmraClients\Pages;

use App\Filament\Resources\OmraClients\OmraClientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOmraClients extends ListRecords
{
    protected static string $resource = OmraClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
