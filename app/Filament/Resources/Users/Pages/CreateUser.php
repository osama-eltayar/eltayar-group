<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\UserStatus;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * @var array<string, mixed>|null
     */
    protected ?array $salaryData = null;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = null;
        $data['status'] = UserStatus::Pending->value;
        $data['invitation_token'] = Str::random(48);

        if (! empty($data['has_salary']) && isset($data['salary'])) {
            $this->salaryData = $data['salary'];
        }

        unset($data['salary']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->salaryData === null) {
            return;
        }

        /** @var User $user */
        $user = $this->record;

        $user->salaries()->create($this->salaryData);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
