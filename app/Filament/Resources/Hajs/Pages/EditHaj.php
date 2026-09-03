<?php

namespace App\Filament\Resources\Hajs\Pages;

use App\Filament\Resources\Hajs\HajResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHaj extends EditRecord
{
    protected static string $resource = HajResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
