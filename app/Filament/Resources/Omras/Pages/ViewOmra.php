<?php

namespace App\Filament\Resources\Omras\Pages;

use App\Filament\Resources\Omras\OmraResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOmra extends ViewRecord
{
    protected static string $resource = OmraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
