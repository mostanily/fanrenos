<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Artisan;
use App\User;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Link;
use App\Models\Music;
use App\Models\Album;
use App\Models\Visitor;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        if(isWindows()){
            $this->public_path = public_path();
        }else{
            $this->public_path = '/home/mostanily/public_html';
        }

        $this->user = new User;
        $this->article = new Article;
        $this->tag = new Tag;
        $this->comment = new Comment;
        $this->link = new Link;
        $this->music = new Music;
        $this->album = new Album;
        $this->visitor = new Visitor;
        $this->category = new Category;
        $this->models = array('user','article','tag','comment','link','music','album','category');//存在软删除模型
    }

    /**
     * 首页
     * @return [type] [description]
     */
    public function index()
    {
        $today_s = date('Y-m-d 00:00:00',time());
        $today_e = date('Y-m-d 23:59:59',time());
        $data['user_count'] = $this->user->all()->count();
        $data['article_count'] = $this->article->all()->count();
        $data['comment_count'] = $this->comment->all()->count();
        $data['view_count'] = $this->article->all()->sum('view_count');
        $data['all_visitor_count'] = $this->visitor->all()->sum('clicks');
        $data['today_visitor_count'] = $this->visitor->where('created_at','>',$today_s)->orWhere(function($query) use ($today_s,$today_e){
            $query->where('updated_at','<',$today_e)->where('updated_at','>',$today_s);
        })->sum('today_clicks');
        return view('admin.home.index',$data);
    }

    /**
     * 访客记录
     * @return [type] [description]
     */
    public function getVisitor(){
        $today_s = date('Y-m-d 00:00:00',time());
        $today_e = date('Y-m-d 23:59:59',time());
        $visitor = $this->visitor->where('created_at','>',$today_s)->orWhere(function($query) use ($today_s,$today_e){
            $query->where('updated_at','<',$today_e)->where('updated_at','>',$today_s);
        })->orderBy('updated_at','desc')->get()->toArray();
        return response()->json($visitor);
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

    /**
     * 批量删除（只针对存在软删除的model）
     * @param  [type] $model [description]
     * @return [type]        [description]
     */
    public function batch_delete(Request $request,$model){
        if(!in_array($model, $this->models)){
            return redirect()->back()->withErrors('不存在的模型，请检查');
        }
        $pid = $request->get('pid');
        $id_arr = explode(',', $pid);

        $this->$model->destroy($id_arr);

        return response()->json(['status'=>'success']);
    }

    /**
     * 清除缓存
     * @return [type] [description]
     */
    public function cacheClear(){
        Artisan::call('cache:clear');
        $response = ['status'=>'success'];
        return response()->json($response);
    }

    public function getCss()
    {
        //前端资源合并
        header("Content-Type:text/html;charset=UTF-8");
        $conn         = "";
        $path_array[] = $this->public_path.'/layui/css/layui.css';
        $path_array[] = $this->public_path.'/css/style.min.css';
        $path_array[] = $this->public_path.'/css/amazeui.min.css';
        $path_array[] = $this->public_path.'/css/app_amaze.min.css';
        $out_put      = $this->public_path.'/css/public.css';//最终生成的文件名称
        foreach ($path_array as $path) {
            if (file_exists($path)) {
                if ($fp = fopen($path, "a+")) {
                    //读取文件
                    $conn .= fread($fp, filesize($path));
                }
            }
        }
        @file_put_contents($out_put, $conn);

        $response = ['status'=>'success'];
        
        return response()->json($response);
    }

    public function getDashboardCss()
    {     
        //前端CSS资源合并
        header("Content-Type:text/html;charset=UTF-8");
        $conn         = "";
        $path_array[] = $this->public_path.'/layui/css/layui.css';
        $path_array[] = $this->public_path.'/css/style.min.css';
        $path_array[] = $this->public_path.'/libs/font-awesome/4.5.0/css/font-awesome.min.css';
        $path_array[] = $this->public_path.'/libs/ionicons/2.0.1/css/ionicons.min.css';
        $path_array[] = $this->public_path.'/dist/css/skins/skin-blue.min.css';
        $path_array[] = $this->public_path.'/css/animate.min.css';
        $path_array[] = $this->public_path.'/dist/css/load/load.css';
        $path_array[] = $this->public_path.'/css/upload-img.css';

        $out_put      = $this->public_path.'/css/dashboard_public.css';//最终生成的文件名称
        foreach ($path_array as $path) {
            if (file_exists($path)) {
                if ($fp = fopen($path, "a+")) {
                    //读取文件
                    $conn .= fread($fp, filesize($path));
                }
            }
        }
        @file_put_contents($out_put, $conn);

        //js合并
        $js_conn = '';
        $js_path_arr[] = $this->public_path.'/tagsinput-init.js';
        $js_path_arr[] = $this->public_path.'/dist/js/app.min.js';
        $js_path_arr[] = $this->public_path.'/js/content.min.js';
        $js_path_arr[] = $this->public_path.'/dist/js/common.min.js';

        $js_out_put    = $this->public_path.'/js/dashboard_public.js';//最终生成的文件名称
        foreach ($js_path_arr as $p) {
            if (file_exists($p)) {
                if ($fp = fopen($p, "a+")) {
                    //读取文件
                    $js_conn .= fread($fp, filesize($p));
                }
            }
        }
        @file_put_contents($js_out_put, $js_conn);

        $response = ['status'=>'success'];
        
        return response()->json($response);
    }
}
