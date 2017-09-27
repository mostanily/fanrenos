<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('zh');
        
        view()->composer(['layouts.about_me'],function($view){
            $allTag = DB::table('tags')
                    ->leftJoin('article_tag_pivot as ap','ap.tag_id','=','tags.id')
                    ->selectRaw('tags.id,tags.tag,count(ap.article_id) as a_num')
                    ->groupBy('tags.id')
                    ->orderBy('a_num','desc')
                    ->get();

            $view_data = [
                'allTag'=>$allTag,
            ];

            $view->with($view_data);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}