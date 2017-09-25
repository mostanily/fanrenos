<?php

namespace App;
use App\Scopes\StatusScope;
use App\Traits\FollowTrait;
use Illuminate\Notifications\Notifiable;//消息通知
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes,FollowTrait;

    protected $table = 'users';
    public $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'is_admin', 'avatar', 'password', 'confirm_code','occupation','address','company',
        'nickname', 'real_name', 'weibo_name', 'weibo_link','qq', 'email_notify_enabled',
        'github_id', 'github_name', 'github_url', 'website', 'description', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','confirm_code', 'updated_at'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StatusScope());
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment','user_id','id')->orderBy('created_at', 'desc');
    }
}
