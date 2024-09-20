<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CustomLogin;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Monitor;
use App\Filament\Resources\FsrResource\Widgets\FsrOverview;
use App\Filament\Resources\FsrResource\Widgets\LatestFsr;
use App\Filament\Widgets\FsrTotalOverview;
use App\Filament\Widgets\HeaderWidget;
use App\Filament\Widgets\HeaderWidgetLite;
use App\Filament\Widgets\ProjectPie;
use App\Filament\Widgets\ProjectStatus;
use App\Models\User;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use DiscoveryDesign\FilamentGaze\FilamentGazePlugin;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View as ViewView;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->login(CustomLogin::class)
            ->spa()
            ->sidebarFullyCollapsibleOnDesktop()
            ->sidebarCollapsibleOnDesktop()
            ->topNavigation()
            ->breadcrumbs(false)
            ->topbar(true)
            ->maxContentWidth(MaxWidth::SevenExtraLarge)
            ->defaultThemeMode(ThemeMode::Light)
            ->font('Lato')
            ->darkMode(false)
            // ->profile(isSimple: false)
            ->profile(EditProfile::class)
            ->passwordReset()
            ->emailVerification()
            ->unsavedChangesAlerts()
            ->brandLogo(asset('DB_LOGO_SOLO.svg'))
            ->brandLogoHeight('2.8rem')
            // ->brandName('FSR')
            ->colors([
                'primary' => Color::Sky,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                FsrTotalOverview::class,
                HeaderWidget::class,
                HeaderWidgetLite::class,
                ProjectPie::class,
                LatestFsr::class,
                // HeaderWidget::class,
                // FsrOverview::class,
                // ProjectStatus::class,

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchDebounce('750ms')
            ->plugins([
                FilamentGeneralSettingsPlugin::make()
                    ->canAccess(fn() => User::find(1)->isAdmin())
                    ->setSort(19)
                    ->setIcon('heroicon-o-cog')
                    ->setNavigationGroup('Settings')
                    ->setTitle('General Settings')
                    ->setNavigationLabel('General Settings'),
                FilamentGazePlugin::make(),
                // GlobalSearchModalPlugin::make()
                // ->closeByEscaping(enabled: false)
                // ->closeByClickingAway(enabled: false)
                // ->closeButton(enabled: true)
                // ->associateItemsWithTheirGroups()
                // ->SwappableOnMobile(enabled: false)
                // ->RetainRecentIfFavorite(true)
            ])
            ->navigationGroups([

                NavigationGroup::make('FSR')
                    ->label('FSR')
                    ->icon('heroicon-o-flag')
                    ->collapsed(),
                NavigationGroup::make('Projects')
                    ->label('Projects')
                    ->icon('heroicon-o-building-office-2')
                    ->collapsed(),
                NavigationGroup::make('Equipments')
                    ->label('Equipments')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->collapsed(),
                NavigationGroup::make('Personnels')
                    ->label('Personnels')
                    ->icon('heroicon-o-user-group')
                    ->collapsed(),
                NavigationGroup::make('Directory')
                    ->label('Directory')
                    ->icon('heroicon-o-identification')
                    ->collapsed(),
                NavigationGroup::make('Settings')
                    ->label('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
            ]);
    }
}
