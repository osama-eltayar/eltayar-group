<?php

namespace App\Filament\Resources\OmraPrices\Pages;

use App\Filament\Resources\OmraPrices\OmraPriceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOmraPrice extends EditRecord
{
    protected static string $resource = OmraPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
