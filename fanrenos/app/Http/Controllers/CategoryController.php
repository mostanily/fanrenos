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
            $category = $this->category->wherePath($path)->firstOrFail();
            $posts    = $this->article->with('tags')->whereHas('category', function ($q) use ($path) {
                $q->wherePath($path);
            })
                ->orderBy('view_count', 'desc')
                ->orderBy('published_at', 'desc')
                ->simplePaginate(config('blog.posts_per_page'));

            $banner_post = array();
            foreach ($posts as $key => $value) {
                $raw                      = json_decode($value->content, true);
                $max_raw                  = mb_substr($raw['raw'], 0, 40) . '......';
                $posts[$key]->content_raw = $max_raw;
                $posts[$key]->page_image  = empty($value->page_image) ? '' : $this->path . $value->page_image;

                if ($key < 4) {
                    $banner_post[$key] = $posts[$key];
                }
            }

            return [
                'title'             => $category->name,
                'subtitle'          => config('blog.subtitle'),
                'posts'             => $posts,
                'page_image'        => config('blog.page_image'),
                'category'          => $category,
                'bannerPost'        => $banner_post,
                'reverse_direction' => false,
                'meta_description'  => $category->description ?: config('blog.description'),
            ];
        });
        return view('blogs.index', $postData);
    }
}
