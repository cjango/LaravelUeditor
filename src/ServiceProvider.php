<?php

namespace RuLong\Ueditor;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/ueditor.php' => config_path('ueditor.php')]);
            $this->publishes([__DIR__ . '/../resources/ueditor' => public_path('assets/ueditor')]);
            $this->publishes([__DIR__ . '/../resources/umeditor' => public_path('assets/umeditor')]);
        }

        BladeExtends::ueditor();
        BladeExtends::umeditor();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ueditor.php', 'ueditor');
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::middleware(config('ueditor.route.middleware'))->group(function ($router) {
            $router->match(['get', 'post'], 'ueditor/server', '\RuLong\Ueditor\Controller@server');
        });
    }
}
