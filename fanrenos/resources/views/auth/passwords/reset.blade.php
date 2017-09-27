@extends('layouts.app')
@section('title','重置密码')
@section('header')
<button type="button" class="am-btn am-btn-default am-radius log-button" onclick="toJump('{{url("login")}}')">登录</button>
<button type="button" class="am-btn am-btn-default am-radius log-button" onclick="toJump('{{url("register")}}')">注册</button>
@stop

@section('content')
<div class="log"> 
    <div class="am-g">
        <div class="am-u-lg-6 am-u-md-8 am-u-sm-8 am-u-sm-centered log-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">Reset Password</div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label" style="color: #000;">邮箱</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="原账号注册邮箱" autofocus style="color: #000;">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label" style="color: #000;">密码</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password" style="color: #000;">

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <label for="password-confirm" class="col-md-4 control-label" style="color: #000;">确认密码</label>
                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" style="color: #000;">

                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                确认重置
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
