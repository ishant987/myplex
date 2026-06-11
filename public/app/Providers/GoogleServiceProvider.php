<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as Socialite;

class GoogleServiceProvider extends ServiceProvider
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
        $socialite->extend('google', function ($app) use ($socialite) 
        {
            return $socialite->buildProvider(\Laravel\Socialite\Two\GoogleProvider::class, config('services.google'));
        });
    }
}
