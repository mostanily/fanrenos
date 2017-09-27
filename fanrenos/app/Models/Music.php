<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use SoftDeletes;
    protected $table = 'musics';
    public $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'title', 'album', 'artist','image', 'play_time', 'mime_type','size','lrc'
    ];
}
