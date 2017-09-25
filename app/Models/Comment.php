<?php

namespace App\Models;

use Markdown;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    protected $table = 'comments';
    protected $primaryKey ='id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'content','commentable_id','user_id','commentable_type','is_reply_author','reply_author_name'
    ];

    public function article()
    {
        return $this->belongsTo('App\Models\Article','commentable_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function thumbs(){
        return $this->hasMany('App\Models\CommentThumb','comment_id','id');
    }

    public function setIsReplyAuthor($value){
        $this->attributes['is_reply_author'] = $value;
    }

    public function setReplyAuthorName($value){
        $this->attributes['reply_author_name'] = $value;
    }

    public function setContentAttribute($value)
    {
        $to_html = Markdown::convertToHtml($value);
        $reply_author = $this->is_reply_author;
        $auth_user_url = auth_user_url($this->reply_author_name);

        if(!empty($reply_author)){
            $to_html = preg_replace('/'.$reply_author.'/i','<a href="'.$auth_user_url.'">'.$reply_author.' </a>',$to_html);
        }

        $data = [
            'raw'  => $value,
            'html' => $to_html,
        ];

        $this->attributes['content'] = json_encode($data,320);
    }
}
