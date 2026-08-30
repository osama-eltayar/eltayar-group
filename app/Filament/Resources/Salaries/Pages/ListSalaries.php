<?php

namespace App\Filament\Resources\Salaries\Pages;

use App\Filament\Resources\Salaries\SalaryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSalaries extends ListRecords
{
    protected static string $resource = SalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'active' => Tab::make(__('salary.active'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereNull('ended_at')),
            'all' => Tab::make(__('salary.all')),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'active';
    }
}
