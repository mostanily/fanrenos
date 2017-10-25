@extends('admin.layouts.app')
@section('title','用户登录 | 后台管理')
@section('content')
<dl class="admin_login">
    <dt>
        <strong>后台管理-登陆</strong>
        <em>Management System</em>
    </dt>
    <form class="am-form" role="form" method="POST" action="{{ url('/dashboard/login') }}">
        {{ csrf_field() }}
        <dd class="email_icon">
            <input type="email" placeholder="登录邮箱名" name="email" class="login_txtbx" required="" />
        </dd>
        <dd class="pwd_icon">
            <input type="password" placeholder="密码" name="password" class="login_txtbx" required="" />
        </dd>
        <dd class="rem_icon">
            <label style="cursor: pointer;"><input type="checkbox" name="remember" checked="checked" class="login_remember" />&nbsp;&nbsp;记&nbsp;住&nbsp;我</label>
        </dd>
        <dd>
            <input type="submit" value="立即登陆" class="submit_btn" />
        </dd>
    </form>
    <dd>
        <p>Copyright © {{ config('blog.author') }} 2017. Made with love</p>
        <p><a href="{{url('/')}}">{{config('blog.name')}}</a></p>
    </dd>
</dl>
@endsection
{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户登录 | 后台管理</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/libs/font-awesome/4.5.0/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('/libs/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/dist/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('/plugins/iCheck/square/blue.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="/libs/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
@include('admin.partials.errors')
@include('admin.partials.success')
<div class="login-box">
    <div class="login-logo">
        <a><b>后台管理</b>v1.0</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">登录</p>

        <form action="{{ url('/dashboard/login') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="登录邮箱名"  name="email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control"  name="password" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" checked="checked">&nbsp;&nbsp;记&nbsp;住&nbsp;
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="{{asset('/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html> --}}
