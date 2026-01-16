<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

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
        // //
        // Force Livewire to use the correct asset and update paths
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/lynxweb/lynxadmin/public/livewire/update', $handle);
        });

        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/lynxweb/lynxadmin/public/livewire/livewire.js', $handle);
        });
    }
}
