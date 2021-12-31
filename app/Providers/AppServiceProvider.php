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
        // dd($host);
        if ($host != "127.0.0.1:8000") {
            \URL::forceScheme('https');
        }

    }
}
