<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {

        $domainWeb = env('DOMAIN_WEB');
        $domainAdmin = env('DOMAIN_ADMIN');
        $domain = preg_replace('#^https?://#', '', Request::root());
        if($domain=="www.".$domainWeb)
        {
            $domainWeb = $domain;
        }

        if($domain=="www.".$domainAdmin)
        {
            $domainAdmin = $domain;
        }

        if (env('MAINTAIN',false)) {
            Route::middleware('web')->group(base_path('routes/maintain.php'));
            return;
        }

        Route::domain($domainWeb)
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        Route::domain($domainAdmin)
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin_web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $domainWeb = env('DOMAIN_WEB');
        $domainAdmin = env('DOMAIN_ADMIN');
        $domain = preg_replace('#^https?://#', '', Request::root());
        if($domain=="www.".$domainWeb)
        {
            $domainWeb = $domain;
        }


        if($domain=="www.".$domainAdmin)
        {
            $domainAdmin = $domain;
        }

        if (env('MAINTAIN',false)) {
            Route::middleware('api')->group(base_path('routes/maintain.php'));
            return;
        }

        Route::domain($domainWeb)
            ->prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

        Route::domain($domainAdmin)
            ->prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin_api.php'));
    }
}
