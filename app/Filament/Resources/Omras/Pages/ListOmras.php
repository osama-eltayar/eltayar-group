<?php

namespace App\Filament\Resources\Omras\Pages;

use App\Filament\Resources\Omras\OmraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOmras extends ListRecords
{
    protected static string $resource = OmraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
