<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentTimezone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentTimezone::set(fn (): string => Auth::user()?->timezone ?: config('app.display_timezone'));
    }
}
