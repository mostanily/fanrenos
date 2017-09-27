<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AlbumController extends Controller
{
    public function index(){
        $data = [
            'title' => config('blog.title').'|相册壁纸',
            'subtitle' => config('blog.subtitle'),
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
        ];

        return view('blogs.album',$data);
    }
}
