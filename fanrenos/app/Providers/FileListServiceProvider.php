<?php

namespace App\Providers;

use App\Services\FileListService;
use Illuminate\Support\ServiceProvider;

/**
 * 获取文件夹下的文件信息
 */
class FileListServiceProvider extends ServiceProvider
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
        $this->app->bind('fileList', function () {
            return new FileListService();
        });
    }
}
