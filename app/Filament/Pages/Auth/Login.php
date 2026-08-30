<?php

namespace App\Filament\Pages\Auth;

use App\Models\Branch;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getBranchFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getBranchFormComponent(): Component
    {
        return Select::make('branch_id')
            ->label(__('branch.singular_label'))
            ->options(fn (): array => Branch::query()->pluck('name', 'id')->all())
            ->searchable()
            ->native(false)
            ->required();
    }

    public function authenticate(): ?LoginResponse
    {
        $branchId = $this->data['branch_id'] ?? null;

        $response = parent::authenticate();

        if ($response !== null && $branchId !== null) {
            session()->put('branch_id', $branchId);
        }

        return $response;
    }
}
