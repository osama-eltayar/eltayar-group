<?php

namespace App\Filament\Resources\Hajs\Pages;

use App\Filament\Resources\Hajs\HajResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHajs extends ListRecords
{
    protected static string $resource = HajResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
