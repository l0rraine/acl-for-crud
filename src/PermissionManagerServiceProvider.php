<?php

namespace Qla\PermissionManager;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PermissionManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // LOAD THE VIEWS
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/vendor/qla/usercrud'), 'usercrud');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'usercrud');


        // LOAD CONFIG
        $this->mergeConfigFrom(
            __DIR__.'/config/qla/usercrud.php', 'qla.usercrud'
        );

        $this->mergeConfigFrom(
            __DIR__.'/config/qla/rolecrud.php', 'qla.rolecrud'
        );



        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/qla/permissionmanager'),
            __DIR__.'/database/migrations' => database_path('migrations'),
            __DIR__.'/config/qla' => config_path('qla'),
        ], 'qla');

    }

    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Qla\UserCRUD\app\Http\Controllers'], function ($router) {
            \Route::group(['prefix' => config('qla.base.route_prefix', 'manager'), 'middleware' => config('qla.base.admin_auth_middleware',['web'])], function () {
                require __DIR__.'/routes/usercrud.php';
            });
        });
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupRoutes($this->app->router);
        $this->app->register('Kodeine\Acl\AclServiceProvider');
    }
}
