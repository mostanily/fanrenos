<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Admin;
use Validator;
use Auth;
use Redirect;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }
    /**
     * 自定义认证驱动
     * @return [type]                   [description]
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    //登录
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateLogin($request->input());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $remember = $request->get('remember',0);
            if (Auth::guard('admin')->attempt(['email'=>$request->email, 'password'=>$request->password],$remember)) {
                return Redirect::to('/dashboard/home')->withSuccess('登录成功！');     //login success, redirect to admin
            } else {
                return back()->withErrors('账号或密码错误')->withInput();
            }
        }
        return view('admin.auth.login');
    }
    //登录页面验证
    protected function validateLogin(array $data)
    {
        //dd($data);
        return Validator::make($data, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求，最少6位'
        ], [
            'email' => '邮箱',
            'password' => '密码'
        ]);
    }

    //退出登录
    public function logout()
    {
        $this->guard('admin')->logout();

        request()->session()->flush();

        request()->session()->regenerate();

        return redirect('/dashboard/login');
    }
    //注册
    // public function register(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $validator = $this->validateRegister($request->input());
    //         if ($validator->fails()) {
    //             return back()->withErrors($validator)->withInput();
    //         }
    //         $user = new Admin();
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->password = bcrypt($request->password);
    //         if($user->save()){
    //             return redirect('/dashboard/login')->with('success', '注册成功！');
    //         }else{
    //             return back()->with('error', '注册失败！')->withInput();
    //         }
    //     }
    //     return view('admin.register');
    // }
    // protected function validateRegister(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => 'required|alpha_num|max:255',
    //         'email' => 'required|email|max:255|unique:admins',
    //         'password' => 'required|min:6|confirmed',
    //         'password_confirmation' => 'required|min:6|'
    //     ], [
    //         'required' => ':attribute 为必填项',
    //         'min' => ':attribute 长度不符合要求',
    //         'confirmed' => '两次输入的密码不一致',
    //         'unique' => '该账户已存在',
    //         'alpha_num' => ':attribute 必须为字母或数字',
    //         'max' => ':attribute 长度过长'
    //     ], [
    //         'name' => '昵称',
    //         'email' => '账号',
    //         'password' => '密码',
    //         'password_confirmation' => '确认密码'
    //     ]);
    // }
}
