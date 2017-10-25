@extends('admin.layouts.app')
@section('title','用户注册 | 后台管理')
@section('content')
<dl class="admin_login">
    <dt>
        <strong>后台管理-注册</strong>
        <em>Management System</em>
    </dt>
    <form class="am-form" role="form" method="POST" action="{{ url('/dashboard/register') }}">
        {{ csrf_field() }}
        <dd class="user_icon">
            <input type="text" placeholder="用户名" name="name" class="login_txtbx" required="" />
        </dd>
        <dd class="email_icon">
            <input type="email" placeholder="登录邮箱名" name="email" class="login_txtbx" required="" />
        </dd>
        <dd class="pwd_icon">
            <input type="password" placeholder="密码" name="password" class="login_txtbx" required="" />
        </dd>
        <dd class="pwd_icon">
            <input type="password" placeholder="确认密码" name="password_confirmation" class="login_txtbx" required="" />
        </dd>
        <dd>
            <input type="submit" value="立即注册" class="submit_btn" />
        </dd>
    </form>
    <dd>
        <p>Copyright © {{ config('blog.author') }} 2017. Made with love</p>
        <p><a href="{{url('/')}}">{{config('blog.name')}}</a></p>
    </dd>
</dl>
@endsection
