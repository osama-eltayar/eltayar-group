<?php

namespace App\Filament\Resources\HajClients\Pages;

use App\Filament\Resources\HajClients\HajClientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHajClient extends EditRecord
{
    protected static string $resource = HajClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
