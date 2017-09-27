<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Link;
use App\Models\Music;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
        $this->article = new Article;
        $this->tag = new Tag;
        $this->comment = new Comment;
        $this->link = new Link;
        $this->music = new Music;
        $this->models = array('user','article','tag','comment','link','music');//存在软删除的模型
    }

    public function index()
    {
        $data['user_count'] = $this->user->all()->count();
        $data['article_count'] = $this->article->all()->count();
        $data['comment_count'] = $this->comment->all()->count();
        $data['view_count'] = $this->article->all()->sum('view_count');
        return view('admin.home.index',$data);
    }

    /**
     * 恢复被软删除的信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function recycle_normal($handle,$id){
        if(!in_array($handle, $this->models)){
            return redirect()->back()->withErrors('不存在的模型，请检查');
        }
        if($handle=='user' || $handle=='article'){
            $this->$handle->withoutGlobalScopes()->onlyTrashed()->where('id',(int)$id)->restore();
            //如果是用户信息，恢复后需要调整用户的状态
            if($handle=='user'){
                $this->user->withoutGlobalScopes()->where('id',(int)$id)->update(['status'=>1]);
            }
        }else{
            $this->$handle->onlyTrashed()->where('id',(int)$id)->restore();
        }

        return redirect('/dashboard/'.$handle.'/index')
                        ->withSuccess("恢复成功");
    }
}
