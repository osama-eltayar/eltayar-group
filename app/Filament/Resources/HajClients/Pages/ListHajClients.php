<?php

namespace App\Filament\Resources\HajClients\Pages;

use App\Enums\HajClientStatus;
use App\Filament\Resources\HajClients\HajClientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListHajClients extends ListRecords
{
    protected static string $resource = HajClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('haj_client.all')),
            'chosen' => Tab::make(__('haj_client.chosen'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', HajClientStatus::Chosen)),
        ];
    }
}
