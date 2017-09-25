<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PinYinService;

class PinYinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('pinyin', function () {
            return new PinYinService();
        });
    }
}
