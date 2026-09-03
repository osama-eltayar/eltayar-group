<?php

namespace App\Filament\Resources\OmraPrices\Pages;

use App\Filament\Resources\OmraPrices\OmraPriceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOmraPrices extends ListRecords
{
    protected static string $resource = OmraPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
