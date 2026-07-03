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
        // Register DATE_FORMAT polyfill for SQLite connections dynamically
        \Event::listen(\Illuminate\Database\Events\StatementPrepared::class, function ($event) {
            $connection = $event->connection;
            if ($connection instanceof \Illuminate\Database\SQLiteConnection) {
                static $registered = [];
                $id = spl_object_hash($connection);
                if (!isset($registered[$id])) {
                    $connection->getPdo()->sqliteCreateFunction('DATE_FORMAT', function ($date, $format) {
                        if (!$date) return null;
                        try {
                            $d = new \DateTime($date);
                            $mysqlToPhp = [
                                '%Y' => 'Y', '%y' => 'y', '%m' => 'm', '%d' => 'd',
                                '%H' => 'H', '%i' => 'i', '%s' => 's', '%W' => 'l',
                                '%M' => 'F', '%b' => 'M', '%c' => 'n', '%e' => 'j'
                            ];
                            $phpFormat = str_replace(array_keys($mysqlToPhp), array_values($mysqlToPhp), $format);
                            return $d->format($phpFormat);
                        } catch (\Exception $e) {
                            return null;
                        }
                    });
                    $registered[$id] = true;
                }
            }
        });

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
           \View::composer(
            'web.*', 'App\Http\View\Composers\FaqComposer'
           );
        Collection::macro('setAppends', function ($attributes) {
            return $this->map(function ($item) use ($attributes) {
                return $item->setAppends($attributes);
            });
        });

        require_once app_path('Helpers/helpers.php');
    }
}
