@extends('layouts.app')
@section('title','注册')
@section('header')
<button type="button" class="am-btn am-btn-default am-radius log-button" onclick="toJump('{{url("login")}}')">登录</button>
@stop

@section('content')
<div class="log"> 
    <div class="am-g">
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-8 am-u-sm-centered log-content">
            <h1 class="log-title am-animation-slide-top">{{ config('blog.name') }}</h1>
            <br>
            <form class="am-form" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="am-input-group am-radius am-animation-slide-left">       
                    <input type="text" name="name" class="am-radius" data-validation-message="用户名" placeholder="用户名" required/>
                    <span class="am-input-group-label log-icon am-radius"><i class="am-icon-user am-icon-sm am-icon-fw"></i></span>
                </div>
                <br>
                <div class="am-input-group am-radius am-animation-slide-left">       
                    <input type="email" name="email" class="am-radius" data-validation-message="请输入正确邮箱地址" placeholder="邮箱" required/>
                    <span class="am-input-group-label log-icon am-radius"><i class="am-icon-envelope am-icon-sm am-icon-fw"></i></span>
                </div>
                <br>
                <div class="am-input-group am-animation-slide-left log-animation-delay">       
                    <input type="password" name="password" id="log-password" class="am-form-field am-radius log-input" placeholder="密码" minlength="11" required>
                    <span class="am-input-group-label log-icon am-radius"><i class="am-icon-lock am-icon-sm am-icon-fw"></i></span>
                </div>
                <br>   
                <div class="am-input-group am-animation-slide-left log-animation-delay-a">       
                    <input type="password" name="password_confirmation" data-equal-to="#log-password" class="am-form-field am-radius log-input" placeholder="确认密码" data-validation-message="请确认密码一致" required>
                    <span class="am-input-group-label log-icon am-radius"><i class="am-icon-lock am-icon-sm am-icon-fw"></i></span>
                </div>
                <br>
                <button type="submit" class="am-btn am-btn-primary am-btn-block am-btn-lg am-radius am-animation-slide-bottom log-animation-delay-b">注 册</button>
                <br>
            </form>
        </div>
    </div>
</div>

@endsection
