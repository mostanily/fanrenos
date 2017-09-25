<?php

namespace App\Models;

use App\Scopes\DraftScope;
use Markdown;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';
    public $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'subtitle',
        'slug',
        'page_image',
        'content',
        'meta_description',
        'is_draft',
        'is_original',
        'published_at',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DraftScope());
    }

    /**
     * Get the category for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function tags()
    {
         return $this->belongsToMany('App\Models\Tag', 'article_tag_pivot','article_id','tag_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment','commentable_id','id');
    }

    /**
     * Sync tag relation adding new tags as needed
     *
     * @param array $tags
     */
    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if (count($tags)) {
            $this->tags()->sync(
                Tag::whereIn('tag', $tags)->pluck('id')->toArray()
            );
            return;
        }

        $this->tags()->detach();
    }

    /**
     * Return the date portion of published_at
     */
    public function getPublishDateAttribute($value)
    {
        return $this->published_at->format('M-j-Y');
    }

    /**
     * Return the time portion of published_at
     */
    public function getPublishTimeAttribute($value)
    {
        return $this->published_at->format('g:i A');
    }

    /**
     * Get the created at attribute.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }

    /**
     * Set the title and the readable slug.
     * 
     * @param string $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        $pinyin = app('pinyin')->get($value,'utf-8');

        $this->setUniqueSlug($pinyin, '');

        // if (!config('services.youdao.key') || !config('services.youdao.from')) {
        //     $this->setUniqueSlug($value, '');
        // } else {
        //     $this->attributes['slug'] = translug($value);
        // }
    }

    /**
     * Set the unique slug.
     *
     * @param $value
     * @param $extra
     */
    public function setUniqueSlug($value, $extra) {
        $slug = str_slug($value.'-'.$extra);
        if (static::whereSlug($slug)->exists()) {
            $this->setUniqueSlug($slug, (int) $extra + 1);
            return;
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Set the content attribute.
     *
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $data = [
            'raw'  => $value,
            'html' => Markdown::convertToHtml($value),
        ];

        $this->attributes['content'] = json_encode($data,320);
    }

    /**
     * Return URL to post
     *
     * @param Tag $tag
     * @return string
     */
    public function url(Tag $tag = null)
    {
        $url = url('blog/'.$this->slug);
        if ($tag) {
          $url .= '?tag='.urlencode($tag->tag);
        }

        return $url;
    }

    /**
     * Return array of tag links
     *
     * @param string $base
     * @return array
     */
    public function tagLinks($base = '/blog?tag=%TAG%')
    {
        $tags = $this->tags()->pluck('tag');
        $return = [];
        foreach ($tags as $tag) {
          $url = str_replace('%TAG%', urlencode($tag), $base);
          $return[] = '<a href="'.url($url).'">'.e($tag).'</a>';
        }
        return $return;
    }

    /**
     * 返回每篇文章的评论信息
     * @return [type] [description]
     */
    public function commentList()
    {
        $article_id = $this->id;
        $ul_s = '<ul class="am-comments-list am-comments-list-flip">';
        $ul_e = '</ul><hr><p style="text-align: center;"><a href="'.url('/blog/more_comment?blogSlug='.$this->slug).'" target="_blank">点击查看更多评论>></a></p>';
        $li_comment = '';
        $comments = $this->comments()->with(['user','thumbs'])->orderBy('created_at','asc')->limit(10)->get();
        $return = '';
        //当前登陆用户的id
        if(!Auth::guest()){
            $auth_uid = Auth::user()->id;
        }
        if(!$comments->isEmpty()){
            foreach ($comments as $key => $comment) {
                //评论人的信息
                $author_name = empty($comment->user->nickname) ? $comment->user->name : $comment->user->nickname;
                $avatar = empty($comment->user->avatar) ? asset('images/default.png') : asset('uploads/avatar/60x60/'.$comment->user->avatar);
                $time = Carbon::parse($comment->created_at)->timestamp;
                $date_time = date('Y年m月d日 H:i:s',$time);
                $content = json_decode($comment->content,true);
                $comment_content = $content['html'];
                $user_url = auth_user_url($comment->user->name);

                $li_class = '';
                if($key%2!=0){
                    $li_class = 'am-comment-flip';
                }
                $is_has_del = '';
                $is_has_love = '';
                $is_has_comment = '';
                $unlike_content_class = '';
                //只有在用户登陆的情况下才会有回复等功能
                if(!Auth::guest()){
                    //只有在登陆情况下，点赞的信息才有意义
                    //每个评论的点赞信息
                    $thumbs = $comment->thumbs()->get();
                    $thumb_num = '';
                    $like_class = '';
                    $unlike_class = '';
                    $like_user = [];
                    $unlike_user = [];
                    
                    foreach ($thumbs as $k => $thumb) {
                        $status = $thumb->status;
                        $thumb_user_id = $thumb->user_id;
                        if($status==0){
                            $unlike_user[] = $thumb_user_id;
                        }else{
                            $like_user[] = $thumb_user_id;
                        }
                    }
                    if(count($like_user)>0){
                        $thumb_num = '<big style="margin-left:3px;">'.count($like_user).'</big>';
                    }

                    if(in_array($auth_uid, $like_user)){
                        $like_class = 'am-text-success';
                    }
                    if(in_array($auth_uid, $unlike_user)){
                        $unlike_class = 'am-text-danger';
                        $unlike_content_class = 'downvoted';//在mydefault.css文件中
                    }

                    $is_has_comment = '<a class="comment_reply" data-comment="'.$author_name.'" data-comment-name="'.$comment->user->name.'" href="javascript:;" title="回复"><i class="am-icon-mail-reply am-icon-md"></i></a>';
                    if($comment->user_id==$auth_uid){
                        $is_has_del = '<a class="comment_del" data-comment="'.$comment->id.'" href="javascript:;" title="删除"><i class="am-icon-trash am-icon-md"></i></a>';
                    }else{
                        $is_has_love = '<a class="comment_like" data-comment="'.$comment->id.'" href="javascript:;" title="喜欢"><i class="am-icon-smile-o am-icon-md '.$like_class.'"></i>'.$thumb_num.'</a><a class="comment_unlike" data-comment="'.$comment->id.'" href="javascript:;" title="讨厌"><i class="am-icon-frown-o am-icon-md '.$unlike_class.'"></i></a>';
                    }
                }
                
                $li_comment .= '<li class="am-comment '.$li_class.'">
                                    <a href="'.$user_url.'"><img alt="'.$author_name.'" src="'.$avatar.'" class="am-comment-avatar" width="48" height="48" />
                                    </a>
                                    <div class="am-comment-main">
                                        <header class="am-comment-hd">
                                            <div class="am-comment-meta">
                                                <i class="am-icon-user"></i>
                                                <a href="'.$user_url.'" class="am-comment-author">'.$author_name.'</a>
                                                评论于 <time title="'.$date_time.'">'.$comment->created_at.'</time>
                                                <a href="#reply" class="reply-floor">#'.($key+1).'</a>
                                            </div>
                                            <div class="am-comment-actions">
                                                '.$is_has_love.$is_has_del.$is_has_comment.'
                                            </div>
                                        </header>
                                        <div class="am-comment-bd '.$unlike_content_class.'">
                                            <p>'.$comment_content.'</p>
                                        </div>
                                    </div>
                                </li>';
            }
            $return = $ul_s.$li_comment.$ul_e;
        }
        
        return $return;
    }

    /**
     * Return next post after this one or null
     *
     * @param Tag $tag
     * @return Post
     */
    public function newerPost(Tag $tag = null)
    {
        $query =
          static::where('published_at', '>', $this->published_at)
            ->where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'asc');
        if ($tag) {
          $query = $query->whereHas('tags', function ($q) use ($tag) {
            $q->where('tag', '=', $tag->tag);
          });
        }

        return $query->first();
    }

    /**
     * Return older post before this one or null
     *
     * @param Tag $tag
     * @return Post
     */
    public function olderPost(Tag $tag = null)
    {
        $query =
          static::where('published_at', '<', $this->published_at)
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc');
        if ($tag) {
          $query = $query->whereHas('tags', function ($q) use ($tag) {
            $q->where('tag', '=', $tag->tag);
          });
        }

        return $query->first();
    }

}
