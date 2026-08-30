<?php

namespace App\Filament\Resources\Salaries\Pages;

use App\Filament\Resources\Salaries\SalaryResource;
use App\Models\User;
use App\Services\Salary\EndActiveSalaryService;
use Filament\Resources\Pages\CreateRecord;

class CreateSalary extends CreateRecord
{
    protected static string $resource = SalaryResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var User $user */
        $user = User::query()->findOrFail($data['user_id']);

        app(EndActiveSalaryService::class)->execute($user, $data['started_at']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
