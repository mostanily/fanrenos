@extends('layouts.app')
@section('title','登录')
@section('header')
<button type="button" class="am-btn am-btn-default am-radius log-button" onclick="toJump('{{url("register")}}')">注册</button>
@stop

@section('content')
<div class="log"> 
    <div class="am-g">
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-8 am-u-sm-centered log-content">
            <h1 class="log-title am-animation-slide-top">{{ config('blog.name') }}</h1>
            <br>
            <form class="am-form" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="am-input-group am-radius am-animation-slide-left">       
                    <input type="email" name="email" class="am-radius" data-validation-message="请输入正确邮箱地址" placeholder="邮箱" required/>
                    <span class="am-input-group-label log-icon am-radius"><i class="am-icon-envelope am-icon-sm am-icon-fw"></i></span>
                </div>      
                <br>
                <div class="am-input-group am-animation-slide-left log-animation-delay">       
                    <input type="password" name="password" class="am-form-field am-radius log-input" placeholder="密码" minlength="8" required>
                    <span class="am-input-group-label log-icon am-radius"><i class="am-icon-lock am-icon-sm am-icon-fw"></i></span>
                </div>      
                <br>
                <div class="am-input-group am-animation-slide-left">
                    <label style="cursor: pointer;"><input type="checkbox" name="remember" checked="checked">&nbsp;&nbsp;记&nbsp;住&nbsp;我</label> 
                </div> 
                <br>
                <button type="submit" class="am-btn am-btn-primary am-btn-block am-btn-lg am-radius am-animation-slide-bottom log-animation-delay">登 录</button>
                    <p class="am-animation-slide-bottom log-animation-delay"><a href="#myModal" data-toggle="modal">忘记密码?</a></p>
            </form>
        </div>
    </div>
</div>
    <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">关闭</span>
                    </button>
                    <i class="am-icon-laptop modal-icon"></i>
                    <h4 class="modal-title">密码重置</h4>
                    <small class="font-bold">此处您将进行密码重置服务</small>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p><strong>注意</strong> 如果你是误操作或出于好奇而点击出现此弹窗的，又没想过更换网站密码的，请关闭窗口即可。<br>如果你确定需要修改网站密码，请在下面的表单，填写上你<b>注册时填写的邮箱</b>，并保证你填写的邮箱确实<b>能接受到邮件</b>才可以进行邮箱重置密码操作。<br>如果你的注册邮箱不能使用，可以到个人面板修改好能用的邮箱后再来进行密码重置操作！<br>如果你确实不记得密码，且注册邮箱已经不能使用，请使用网站的“Contact/联系我”链接，<a href="{{url('contact')}}" target="_blank">传送门</a>；说明来由且留下有关账号的一些信息，本人收到后，将会重置你的账号密码，并将密码通过邮箱回复给你。</p>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>邮箱</label> 
                            <input type="email" placeholder="请输入您的注册Email" class="form-control" name="email" value="{{ old('email') }}" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">发送</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('/plugins/layer/layer.min.js') }}"></script>
@stop