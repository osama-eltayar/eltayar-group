<?php

namespace App\Filament\Resources\Omras\Pages;

use App\Filament\Resources\Omras\OmraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOmra extends EditRecord
{
    protected static string $resource = OmraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
