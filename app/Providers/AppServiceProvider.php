<?php

namespace App\Providers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\View\WidgetsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Pulse\Facades\Pulse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {

    // FilamentView::registerRenderHook(
    //         WidgetsRenderHook::TABLE_WIDGET_START,
    //         fn (array $scopes): View => view('filament.loader', ['scopes' => $scopes]),
    //         // scopes: \App\Filament\Resources\DbeDirectoryResource::class,
    //         scopes: \Livewire\Livewire::current(),
            
    //         );

    }
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });

        Pulse::user(fn($user) => [
            'name' => $user->name,
            'extra' => $user->email,
            'avatar' => asset('storage/' . $user->picture) ? asset('DB_LOGO_SOLO.svg') : null,
        ]);


        FilamentView::registerRenderHook(
            PanelsRenderHook::PAGE_START,
            fn (array $scopes): View => view('filament.loader', ['scopes' => $scopes]),
            // scopes: \App\Filament\Resources\DbeDirectoryResource::class,
            scopes: \Livewire\Livewire::current(),
            );

    
             // FilamentView::registerRenderHook(
        //     PanelsRenderHook::FOOTER,
        //     fn (array $scopes): string => Blade::render('filament.custom-footer', ['scopes' => $scopes]),
        //     scopes: \App\Filament\Resources\DbeDirectoryResource::class,
        // );


        
    }
}
