<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Providers\LumenServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
        $this->app->register(LumenServiceProvider::class);
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // Auth::viaRequest('jwt', function ($request) {
        //     if ($token = $request->bearerToken()) {
        //         $user = JWTAuth::parseToken()->authenticate();
        //         return new User(['id' => $user->id, 'email' => $user->email]);
        //     }
        // });
    }
}
