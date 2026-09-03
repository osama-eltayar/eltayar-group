<?php

namespace App\Filament\Resources\OmraPrices\Pages;

use App\Filament\Resources\OmraPrices\OmraPriceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOmraPrice extends ViewRecord
{
    protected static string $resource = OmraPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
