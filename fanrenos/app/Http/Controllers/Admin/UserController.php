<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $fields = [
        'name' => '',
        'nickname' => '',
        'email' => '',
        'password' => '',
        'website' => NULL,
        'description' => '',
    ];

    public function __construct()
    {
        $this->user = new User;
    }

    /**
     * 首页
     * @return [type] [description]
     */
    public function index(){
        $soft = $this->user->withoutGlobalScopes()->onlyTrashed()->count();
        $users = $this->user->orderBy('created_at','desc')->paginate(12);
        return view('admin.user.index',['user_info'=>$users,'soft'=>$soft]);
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        $users = $this->user->withoutGlobalScopes()->onlyTrashed()->orderBy('created_at','desc')->paginate(12);
        return view('admin.user.recycle_index',['user_info'=>$users]);
    }

    /**
     * 添加操作的页面
     * @return [type] [description]
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['user_tags'] = array();
        return view('admin.user.create', $data);
    }

    /**
     * 保存
     * @param  UserRequest $request [description]
     * @return [type]               [description]
     */
    public function store(UserRequest $request)
    {

        foreach (array_keys($this->fields) as $field) {
            if($field=='password'){
                $this->user->password = bcrypt($request->get('password'));
            }else{
                $this->user->$field = $request->get($field);
            }
        }
        $this->user->role_tag = empty($request->get('user_tags')) ? NULL : implode(',', $request->get('user_tags'));
        $this->user->confirm_code = str_random(64);
        $this->user->status = 1;
        $this->user->email_notify_enabled = 'no';

        $this->user->save();

        return redirect('/dashboard/user/index')->withSuccess('添加成功！');
    }

    /**
     * 编辑操作页面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $Users =$this->user->find((int)$id);
        if (!$Users) return redirect('/dashboard/user/index')->withErrors("找不到该用户!");

        foreach ($this->fields as $field => $value) {
            $data[$field] = old($field, $Users->$field);
        }
        $data['id'] = (int)$id;
        $data['user_tags'] = explode(',',$Users->role_tag);

        return view('admin.user.edit', $data);
    }

    /**
     * 更新操作
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request,$id)
    {
        $Users = $this->user->find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            if($field!='name'){
                if($field=='password'){
                    if(!empty($request->get('password'))){
                        $Users->$field = bcrypt($request->get('password'));
                    }
                }else{
                    $Users->$field = $request->get($field);
                }
            }
        }
        $Users->role_tag = empty($request->get('user_tags')) ? NULL : implode(',', $request->get('user_tags'));
        $Users->save();

        return redirect('/dashboard/user/index')->withSuccess('修改成功！');
    }

    /**
     * 删除
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $user = $this->user->find((int)$id);

        if ($user) {
            //同时修改其用户状态
            $user->update(['status'=>0]);
            $user->delete();
            //暂时先不做彻底删除功能
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }

        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
