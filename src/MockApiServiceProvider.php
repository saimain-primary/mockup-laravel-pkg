<?php

namespace Saimain\LaravelMockApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MockApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mock-api.php', 'mock-api');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mock-api');

        $this->publishes([
            __DIR__.'/../config/mock-api.php' => config_path('mock-api.php'),
        ], 'mock-api-config');

        if (! config('mock-api.enabled')) {
            return;
        }

        // Deferred until every provider has booted so the host application's own
        // routes are always registered first — the catch-all mock route must never
        // have a chance to shadow a real, explicitly-defined route.
        $this->app->booted(fn () => $this->registerRoutes());
    }

    protected function registerRoutes(): void
    {
        Route::middleware(config('mock-api.api_middleware'))
            ->prefix(config('mock-api.api_prefix'))
            ->group(__DIR__.'/../routes/api.php');

        Route::middleware(config('mock-api.panel_middleware'))
            ->prefix(config('mock-api.panel_prefix'))
            ->name('mock-api.panel.')
            ->group(__DIR__.'/../routes/panel.php');
    }
}
