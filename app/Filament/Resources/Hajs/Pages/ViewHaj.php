<?php

namespace App\Filament\Resources\Hajs\Pages;

use App\Filament\Resources\Hajs\HajResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHaj extends ViewRecord
{
    protected static string $resource = HajResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
