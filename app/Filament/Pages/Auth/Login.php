<?php

namespace App\Filament\Pages\Auth;

use App\Models\Branch;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

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

            activity('auth')
                ->causedBy(Auth::user())
                ->withProperties([
                    'branch' => Branch::query()->find($branchId)?->name,
                    'ip' => request()->ip(),
                ])
                ->event('login')
                ->log('User logged in');
        }

        return $response;
    }
}
