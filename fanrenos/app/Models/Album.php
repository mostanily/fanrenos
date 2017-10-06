<?php

namespace App\Models;

use App\Scopes\OrderByScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    protected $table = 'albums';
    public $primaryKey = 'id';

    protected $guarded = [];
    protected $dates = ['deleted_at'];
    
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByScope());
    }
}
