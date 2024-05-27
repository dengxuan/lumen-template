<?php

namespace App\Providers;

use App\Extensions\Http\RequestExtensions;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\MigrationServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(DatabaseServiceProvider::class);
        $this->app->register(MigrationServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
    }

    public function boot()
    {
        // Register the object macro for the Request class
        Request::macro('object', function ($keys = null) {
            return RequestExtensions::createFrom(request())->object($keys);
        });
    }
}
