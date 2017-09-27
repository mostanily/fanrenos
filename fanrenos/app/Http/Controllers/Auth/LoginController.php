<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Auth;
use Redirect;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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

            if (Auth::guard()->attempt(['email'=>$request->email, 'password'=>$request->password],$remember)) {
                return redirect()->intended('/');
                //return Redirect::to('/')->withSuccess('登录成功！');     //login success, redirect to admin
            } else {
                return back()->withErrors('账号或密码错误')->withInput();
            }
        }
        return view('auth.login');
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

    //注册
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateRegister($request->input());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->website = $request->get('website',NULL);
            $user->password = bcrypt($request->password);
            $user->status = 1;
            $user->confirm_code = str_random(64);
            if($user->save()){
                return redirect('/login')->with('success', '注册成功，现在可以登录了！');
            }else{
                return back()->with('error', '注册失败！')->withInput();
            }
        }
        return view('auth.register');
    }
    protected function validateRegister(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|alpha_num|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|'
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'confirmed' => '两次输入的密码不一致',
            'unique' => '该账户已存在',
            'alpha_num' => ':attribute 必须为字母或数字',
            'max' => ':attribute 长度过长'
        ], [
            'name' => '昵称',
            'email' => '账号',
            'password' => '密码',
            'password_confirmation' => '确认密码'
        ]);
    }

    /**
     * 退出登录
     * @return [type] [description]
     */
    public function logout(Request $request) {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        //return Redirect::to('/')->with('message','你现在已经退出登录了!');
        return redirect()->intended('/');
    }
}
