<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        $host = request()->getHttpHost();
        if($this->app->environment('production') || $this->app->environment('staging'))
        {
            \URL::forceScheme('https');
        }
    }
}
