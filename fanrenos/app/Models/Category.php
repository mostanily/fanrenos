<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected $primaryKey ='id';
    
    protected $dates = ['created_at', 'deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'name','path', 'description'
    ];

    /**
     * Get the articles for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class,'category_id','id');
    }

    public function parent()
    {
      return $this->belongsTo('App\Models\Category', 'parent_id','id');
    }

    public function children()
    {
      return $this->hasMany('App\Models\Category', 'parent_id','id');
    }
}
