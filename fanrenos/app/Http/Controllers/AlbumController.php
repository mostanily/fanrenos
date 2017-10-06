<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Http\Requests;

class AlbumController extends Controller
{
    public function index(){
        $album = Album::all();
        $data = [
            'title' => config('blog.title').'|相册壁纸',
            'subtitle' => config('blog.subtitle'),
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'albums' => $album
        ];

        return view('blogs.album',$data);
    }
}
