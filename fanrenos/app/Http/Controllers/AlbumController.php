<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Http\Requests;

class AlbumController extends Controller
{
    /**
     * 相册首页
     * @return [type] [description]
     */
    public function index(){

        $data = Cache::remember(getCacheRememberKey(), config('blog.cache_time.default'), function () {
            $album = Album::all();
            $count = count($album);
            $chunk = ceil($count/4);
            $new_album = $album->chunk($chunk);
            return [
                'title' => config('blog.title').'|相册壁纸',
                'subtitle' => config('blog.subtitle'),
                'page_image' => config('blog.page_image'),
                'meta_description' => config('blog.description'),
                'albums' => $new_album,
                'eachNum' => count($new_album[0]),
            ];
        });
        
        return view('blogs.album',$data);
    }
}
