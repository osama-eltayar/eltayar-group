<?php

namespace App\Filament\Resources\Salaries\Pages;

use App\Filament\Resources\Salaries\SalaryResource;
use App\Models\Salary;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSalary extends ViewRecord
{
    protected static string $resource = SalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            SalaryResource::endSalaryAction(),
            EditAction::make()
                ->visible(fn (Salary $record): bool => SalaryResource::canEdit($record)),
        ];
    }
}
