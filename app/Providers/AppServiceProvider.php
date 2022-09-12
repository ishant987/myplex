<?php

namespace App\Providers;

use App\Resolvers\SocialUserResolver;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        \View::composer(
            'themes/backend/includes/leftnav', 'App\Http\View\Composers\MenuComposer'
        );
        \View::composer(
            'themes.frontend.includes.*', 'App\Http\View\Composers\MenuComposer'
        );
        \View::composer(
         'themes.frontend.includes.*', 'App\Http\View\Composers\FrontendincludesComposer'
        );
        // author :sandeep / 05-09-2022
        \View::composer(
            'web.layout.includes.*', 'App\Http\View\Composers\HeaderAndFooterComposer'
        );
        \View::composer(
            'web.layout.includes.*', 'App\Http\View\Composers\FrontendincludesComposer'
           );
        Collection::macro('setAppends', function ($attributes) {
            return $this->map(function ($item) use ($attributes) {
                return $item->setAppends($attributes);
            });
        });
    }
}
