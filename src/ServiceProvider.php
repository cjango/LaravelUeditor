<?php

namespace RuLong\Ueditor;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{

    public function boot()
    {
        $this->commands($this->commands);

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/ueditor.php' => config_path('ueditor.php')]);
            $this->publishes([__DIR__ . '/../resources/assets' => public_path('assets/ueditor')]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ueditor.php', 'ueditor');

        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::middleware(config('ueditor.route.middleware'))->group(function ($router) {
            $router->get('ueditor/config', '\RuLong\Ueditor\Controllers\ConfigController@index');
        });
    }
}
