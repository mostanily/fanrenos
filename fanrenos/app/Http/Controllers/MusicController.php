<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Http\Requests;

class MusicController extends Controller
{
    public function __construct($path='songs/')
    {
        $this->path_play = config('blog.uploads.webpath').'/'.$path;
        $this->music = new Music();
    }

    public function index(){
        $music = $this->music->orderBy('artist','asc')->paginate(16);
        $max = count($music);
        foreach ($music as $key => $value) {
            if($key==0){
                $music[$key]->prev = '';
            }else{
                $music[$key]->prev = $music[$key-1]->name;
            }
            if($key==$max-1){
                $music[$key]->next = '';
            }else{
                $music[$key]->next = $music[$key+1]->name;
            }
        }
        $data = [
            'title' => config('blog.title').'|音乐',
            'subtitle' => config('blog.subtitle'),
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'musics'=>$music,
            'path' => $this->path_play,
        ];
        return view('music.index',$data);
    }
}
