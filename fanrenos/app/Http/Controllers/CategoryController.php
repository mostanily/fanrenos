<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Cache;

class CategoryController extends Controller
{
    public function __construct($path = 'articles/')
    {
        $this->path     = $path;
        $this->category = new Category;
        $this->article  = new Article;
    }
    public function getArticleByCategory($path)
    {
        $postData = Cache::remember(getCacheRememberKey(), config('blog.cache_time.default'), function () use ($path) {
            $category = $this->category->with('parent')->wherePath($path)->firstOrFail();
            $posts    = $this->article->with('tags')->whereHas('category', function ($q) use ($path) {
                $q->wherePath($path);
            })
                ->orderBy('view_count', 'desc')
                ->orderBy('published_at', 'desc')
                ->simplePaginate(config('blog.posts_per_page'));

            foreach ($posts as $key => $value) {
                $raw                      = json_decode($value->content, true);
                $max_raw                  = mb_substr($raw['raw'], 0, 40) . '......';
                $posts[$key]->content_raw = $max_raw;
                $posts[$key]->page_image  = empty($value->page_image) ? '' : $this->path . $value->page_image;
            }

            return [
                'title'             => '分类|'.$category->parent->name.'.'.$category->name,
                'subtitle'          => config('blog.subtitle'),
                'posts'             => $posts,
                'page_image'        => config('blog.page_image'),
                'category'          => $category,
                'bannerPost'        => array(),
                'reverse_direction' => false,
                'meta_description'  => $category->description ?: config('blog.description'),
            ];
        });
        return view('blogs.index', $postData);
    }
}
