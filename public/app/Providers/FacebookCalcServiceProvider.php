<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as Socialite;

class FacebookCalcServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Socialite $socialite)
    {
        //
        $socialite->extend('facebook-calc', function ($app) use ($socialite) {
            return $socialite->buildProvider(\Laravel\Socialite\Two\FacebookCalcProvider::class, config('services.facebook-calc'));
        });
    }
}
