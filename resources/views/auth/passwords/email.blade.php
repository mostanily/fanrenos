@extends('layouts.app')
@section('title','重置密码')
@section('header')
<button type="button" class="am-btn am-btn-default am-radius log-button" onclick="toJump('{{url("login")}}')">登录</button>
<button type="button" class="am-btn am-btn-default am-radius log-button" onclick="toJump('{{url("register")}}')">注册</button>
@stop
<!-- Main Content -->
@section('content')
<div class="log"> 
    <div class="am-g">
        <div class="am-u-lg-6 am-u-md-8 am-u-sm-8 am-u-sm-centered log-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">密码重置</div>
                            <div class="panel-body">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label" style="color: #000;">邮箱</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" style="color: #000;">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4" style="text-align: left;">
                                            <button type="submit" class="btn btn-primary">
                                                发送
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
