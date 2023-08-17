<?php

namespace Parkway\Wallet\Sdk;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Parkway\Wallet\Sdk\Http\Middleware\ValidateRequestSignature;

class ParkwayWalletServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('pwsdk.php'),
        ], 'pwsdk-config');
    }

    /**
     * Register the console commands for the package.
     *
     * @return void
     */
    public function register(): void
    {

        #merge configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'pwsdk');

        #add middleware
        app()->make('router')->aliasMiddleware('pwsdk.verify-signature', ValidateRequestSignature::class);

        #register route
        $this->registerRoutes();
    }

    public function registerRoutes()
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
            });
    }
}
