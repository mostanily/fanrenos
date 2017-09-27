<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Experience;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct($path = 'articles/')
    {
        $this->path = $path;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tag = $request->get('tag');

        if($tag){
            $tag = Tag::where('tag', $tag)->firstOrFail();

            $posts = Article::where('published_at', '<=', Carbon::now())
                ->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tag', '=', $tag->tag);
                })
                ->orderBy('view_count','desc')
                ->orderBy('published_at', 'desc')
                ->simplePaginate(config('blog.posts_per_page'));

            $banner_post = array();
            foreach ($posts as $key => $value) {
                $raw = json_decode($value->content,true);
                $max_raw = mb_substr($raw['raw'],0,40).'......';
                $posts[$key]->content_raw = $max_raw;
                $posts[$key]->page_image = empty($value->page_image) ? '' : $this->path.$value->page_image;

                if($key<4){
                    $banner_post[$key] = $posts[$key];
                }
            }

            $posts->addQuery('tag', $tag->tag);

            $page_image = $tag->page_image ?: config('blog.page_image');

            $data = [
                'title' => $tag->title,
                'subtitle' => $tag->subtitle,
                'posts' => $posts,
                'page_image' => $page_image,
                'tag' => $tag,
                'bannerPost' => $banner_post,
                'reverse_direction' => false,
                'meta_description' => $tag->meta_description ?: config('blog.description'),
            ];
        }else{
            $posts = Article::with('tags')
                ->where('published_at', '<=', Carbon::now())
                ->orderBy('view_count','desc')
                ->orderBy('published_at', 'desc')
                ->simplePaginate(config('blog.posts_per_page'));

            $banner_post = array();
            foreach ($posts as $key => $value) {
                $raw = json_decode($value->content,true);
                $max_raw = mb_substr($raw['raw'],0,40).'......';
                $posts[$key]->content_raw = $max_raw;
                $posts[$key]->page_image = empty($value->page_image) ? '' : $this->path.$value->page_image;

                if($key<4){
                    $banner_post[$key] = $posts[$key];
                }
            }

            $data = [
                'title' => config('blog.title').'|喵星在等你',
                'subtitle' => config('blog.subtitle'),
                'posts' => $posts,
                'page_image' => config('blog.page_image'),
                'meta_description' => config('blog.description'),
                'reverse_direction' => false,
                'tag' => null,
                'bannerPost' => $banner_post
            ];
        }

        return view('blogs.blog', $data);
    }

    public function showPost(Request $request,$slug)
    {
        //increment 递增某个字段
        //decrement 递减
        DB::table('articles')->whereSlug($slug)->increment('view_count');

        $post = Article::with(['tags','comments'])->whereSlug($slug)->firstOrFail();
        $post->page_image = empty($post->page_image) ? '' : $this->path.$post->page_image;
        $content = json_decode($post->content,true);
        $post->content_html = $content['html'];
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }
        return view('blogs.post', compact('post', 'tag'));
    }

    /**
     * 全站搜索
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function showSearch(Request $request){

        $key = trim($request->get('key'));
        $s_time = time();
        //判断关键词中是否全是中文
        //preg_match("/[\x7f-\xff]/", $str) 判断是否含有中文
        if(!preg_match("/^[\x7f-\xff]+$/", $key)){
            $str_arr = array();
            $key_str = $key;
        }else{
            $str_arr = utf8_str_split($key);
            $key_str = implode('%',$str_arr);
        }
        $query = 'articles.title like "%'.$key_str.'%" or articles.subtitle like "%'.$key_str.'%" or tags.tag like "%'.$key_str.'%"';

        $result_count = DB::table('articles')
                ->leftJoin('article_tag_pivot as ap','ap.article_id','=','articles.id')
                ->leftJoin('tags','ap.tag_id','=','tags.id')
                ->selectRaw('articles.*,tags.tag')
                ->whereRaw($query)
                ->WhereNull('articles.deleted_at')
                ->groupBy('articles.id')->get();

        $posts = DB::table('articles')
                ->leftJoin('article_tag_pivot as ap','ap.article_id','=','articles.id')
                ->leftJoin('tags','ap.tag_id','=','tags.id')
                ->selectRaw('articles.*,tags.tag')
                ->whereRaw($query)
                ->WhereNull('articles.deleted_at')
                ->groupBy('articles.id')
                ->paginate(20);

        $e_time = time();
        $diff_time = ($e_time-$s_time)/1000;
        
        return view('blogs.search',['key'=>$key,'posts'=>$posts,'diff_time'=>$diff_time,'count'=>count($result_count)]);
    }

    /**
     * 个人简介
     * @return [type] [description]
     */
    public function showPersonerExperience(){
        $experience = Experience::orderBy('year','desc')->get();//此处需要注意，icon需要特殊修改下才行，model层返回的是一个数组
        $data = [
            'title' => config('blog.title').'|放浪不羁的自我',
            'subtitle' => config('blog.subtitle'),
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'experiences' => $experience,
        ];

        return view('blogs.experience',$data);
    }
}
