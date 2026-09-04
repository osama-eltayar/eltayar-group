<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Resources\Users\UserResource;
use App\Http\Middleware\LogoutBannedUsers;
use App\Http\Middleware\SetLocale;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Rmsramos\Activitylog\ActivitylogPlugin;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                NavigationGroup::make(fn (): string => __('navigation.haj')),
                NavigationGroup::make(fn (): string => __('navigation.omra')),
                NavigationGroup::make(fn (): string => __('navigation.bookings')),
                NavigationGroup::make(fn (): string => __('navigation.clients')),
                NavigationGroup::make(fn (): string => __('navigation.transactions')),
                NavigationGroup::make(fn (): string => __('navigation.users')),
                NavigationGroup::make(fn (): string => __('navigation.branches')),
                NavigationGroup::make(fn (): string => __('navigation.tasks')),
                NavigationGroup::make(fn (): string => __('navigation.client_services')),
                NavigationGroup::make(fn (): string => __('navigation.activity_log')),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->plugins([
                ActivitylogPlugin::make()
                    ->navigationGroup(fn (): string => __('navigation.activity_log')),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                SetLocale::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                LogoutBannedUsers::class,
            ])
            ->userMenuItems([
                'changePassword' => fn (): Action => UserResource::changePasswordAction(),
            ])
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER,
                fn (): View => view('filament.locale-switcher'),
            );
    }
}
