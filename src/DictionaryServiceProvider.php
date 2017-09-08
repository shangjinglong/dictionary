<?php
/**
 * Created by PhpStorm.
 * User: shangjinglong
 * Date: 06/09/2017
 * Time: 14:09
 */

namespace Shangjinglong\Dictionary;

use Illuminate\Support\ServiceProvider;

class DictionaryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['dictionary'] = $this->app->share(function ($app) {
            return new Dictionary();
        });
    }

    public function providers()
    {
        return ['dictionary'];
    }
}