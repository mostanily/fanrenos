@extends('layouts.app')
@section('title','注册')
@section('content')
<dl class="admin_login">
    <dt>
        <strong>注册</strong>
        <em>Management System</em>
    </dt>
    <form class="am-form" role="form" method="POST" action="{{ url('/register') }}">
        {{ csrf_field() }}
        <dd class="user_icon">
            <input type="text" placeholder="用户名，不支持中文" name="name" class="login_txtbx" title="支持英文及数字，3到15个字符" pattern="^[0-9a-zA_Z]{3,15}$" required="" />
        </dd>
        <dd class="email_icon">
            <input type="email" placeholder="邮箱，用作登陆" name="email" class="login_txtbx" required="" />
        </dd>
        <dd class="web_icon">
            <input type="text" placeholder="留下您的网站更好，带http前缀" name="website" data-validation-message="没有可以不填" class="login_txtbx" />
        </dd>
        <dd class="pwd_icon">
            <input type="password" placeholder="密码" name="password" id="log-password" class="login_txtbx" required="" />
        </dd>
        <dd class="pwd_icon">
            <input type="password" placeholder="确认密码" name="password_confirmation" data-equal-to="#log-password" class="login_txtbx" data-validation-message="请确认密码一致" required="" />
        </dd>
        <dd>
            <input type="submit" value="立即注册" class="submit_btn" />
        </dd>
        <dd>
            <p>已经拥有账号？点击 <a href="{{url('/login')}}">登陆</a></p>
        </dd>
    </form>
    <dd>
        <p>Copyright © {{ config('blog.author') }} 2017. Made with love</p>
        <p><a href="{{url('/')}}">{{config('blog.name')}}</a></p>
    </dd>
</dl>
@endsection
