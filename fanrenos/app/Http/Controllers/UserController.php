<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;
use App\User;
use App\Image\ImageRepository;
use App\Http\Requests;

class UserController extends Controller
{
    public function __construct($path = 'avatar/')
    {
        if(isWindows()){
            $this->upload_path = public_path('uploads/'). $path;
        }else{
           $this->upload_path = config('blog.base_size_path') . $path; 
       }

        $this->size = config('img_upload.size');
        //对尺寸数据的一点处理
        $this->path_size = getSizePath($this->size);

        $this->user = new User;
    }

    /**
     * 判断是否已经登录，如果是就直接跳转到中心页
     * @return [type] [description]
     */
    public function index(){
        if (Auth::check()) {
            return redirect()->to('/user/' . Auth::user()->name);
        }
        return redirect()->to('/login');
    }

    /**
     * 展示用户的个人中心
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function showUserInfo($name){
        $user = $this->user->where('name',$name)->first();

        if (!isset($user)) {abort(404)};

        $comments = $user->comments->take(10);

        $data = [
            'title' => config('blog.title').'|--'.$name.'个人中心',
            'meta_description' => config('blog.description'),
            'user' =>$user,
            'comments' =>$comments,
        ];

        return view('blogs.user.index',$data);
    }

    /**
     * 当前查看的用户的 关注用户信息
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function following($name)
    {
        $user = $this->user->where('name',$name)->first();

        if (!isset($user)) {abort(404)};

        $followings = $user->followings;

        $data = [
            'title' => config('blog.title').'|个人中心-关注信息',
            'meta_description' => config('blog.description'),
            'user' =>$user,
            'followings' =>$followings,
        ];

        return view('blogs.user.following', $data);
    }

    /**
     * 当前查看的用户的 评论信息
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function comments($name)
    {
        $user = $this->user->where('name',$name)->first();

        if (!isset($user)) {abort(404)};

        $comments = $user->comments;

        $data = [
            'title' => config('blog.title').'|个人中心-评论信息',
            'meta_description' => config('blog.description'),
            'user' =>$user,
            'comments' =>$comments,
        ];

        return view('blogs.user.comments', $data);
    }

    /**
     * 关注
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function doFollow($id)
    {
        $user = $this->user->findOrFail($id);

        if (Auth::user()->isFollowing($id)) {
            Auth::user()->unfollow($id);
        } else {
            Auth::user()->follow($id);
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * 展示编辑个人资料页面
     * @return \Illuminate\Http\Response
     */
    public function showUserProfile()
    {
        if (!\Auth::id()) abort(404);

        $user = $this->user->findOrFail(\Auth::id());

        $data = [
            'title' => config('blog.title').'|个人中心-资料编辑',
            'meta_description' => config('blog.description'),
            'user' =>$user,
        ];

        return view('blogs.user.profile', $data);
    }

    /**
     * Update the specified resource in storage.
     * 更新用户的个人资料
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserProfile(Request $request, $id)
    {
        $input = $request->except(['name', 'email']);

        $user = $this->user->findOrFail($id);

        $user->update($input);

        return redirect()->back();
    }

    /**
     * 修改头像
     * @return [type] [description]
     */
    public function showUserProfileAvatar(){
        if (!\Auth::id()) abort(404);

        $user = $this->user->findOrFail(\Auth::id());

        $data = [
            'title' => config('blog.title').'|个人中心-修改头像',
            'meta_description' => config('blog.description'),
            'user' =>$user,
        ];

        return view('blogs.user.profile_avatar',$data);
    }

    /**
     * 保存头像
     * @param Request $request [description]
     */
    public function UpdateUserProfileAvatar(Request $request,ImageRepository $imageRepository){

        if($request->hasFile('croppedImage')){
            $user = Auth::user();
            $old_avatar = $user->avatar;

            $crop = $request->file('croppedImage');

            checkdir($this->upload_path,$this->path_size);
            $info = $imageRepository->uploadSingleWithSize($crop,$this->upload_path,$this->path_size);

            $user->update(['avatar'=>$info]);
            if(!empty($old_avatar)){
                $imageRepository->deleteWithSize($this->upload_path, $old_avatar,$this->size);
            }
            $response = ['status'=>'success'];
        }else{
            $response = ['status'=>'failed','info'=>'没有上传文件或网络或其他原因导致上传失败，请重试！'];
        }

        return response()->json($response);
    }

    /**
     * 个人设置页面
     * @return [type] [description]
     */
    public function showUserSetting(){
        $data = [
            'title' => config('blog.title').'|个人中心-账号设置',
            'meta_description' => config('blog.description'),
        ];

        return view('blogs.user.setting.index',$data);
    }

    /**
     * Change the user's password.
     * 
     * @param  Request $request
     * @return Redirect
     */
    public function changePassword(Request $request)
    {
        if (! Hash::check($request->get('old_password'), Auth::user()->password)) {
            return redirect()->back()
                             ->withErrors(['old_password' => '原来密码不对，请重试！']);
        }

        Validator::make($request->all(), [
            'old_password' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ])->validate();

        Auth::user()->update(['password' => bcrypt($request->get('password'))]);
        //密码修改成功后，退出登录
        auth()->guard()->logout();
        
        return redirect()->back();
    }
}
