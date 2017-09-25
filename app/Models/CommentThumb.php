<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentThumb extends Model
{
    protected $table = 'comment_thumb';
    protected $primaryKey ='id';
    public $timestamps = false;
    protected $guarded = [];

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment','comment_id','id');
    }
}
