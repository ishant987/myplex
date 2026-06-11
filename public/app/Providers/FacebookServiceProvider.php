<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as Socialite;

class FacebookServiceProvider extends ServiceProvider
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
        $socialite->extend('facebook', function ($app) use ($socialite) {
            return $socialite->buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, config('services.facebook'));
        });
    }
}
