@extends('admin.layouts.base')

@section('title','已删除用户列表')
@section('css')
<style type="text/css">
    .user_profile{position: relative;right: 3px;top: 2px;text-align: right;height: 34px;}
    .user_profile_handle{display: none;text-align: right;}
    .user_descript{max-height: 40px;overflow: hidden;min-height: 40px;}
</style>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row page-title-row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{url('/dashboard/user/index')}}" class="btn btn-success btn-md">
                        <i class="fa fa-mail-reply-all"></i> 返回用户列表
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        @include('admin.partials.errors')
                        @include('admin.partials.success')
                        <div class="panel-heading">
                            <h3 class="panel-title">已经删除用户列表</h3>
                        </div>
                        <div class="panel-body">
                            <div class="wrapper wrapper-content animated fadeInRight" style="background-color: #F3F3F4">
                                <div class="row">
                                    @if($user_info->isEmpty())
                                        <p>暂时还没相关数据哦！</p>
                                    @else
                                        @foreach($user_info as $user)
                                            <div class="col-sm-6 user_profile_info">
                                                <div class="contact-box">
                                                    <a href="javascript:;">
                                                        <div class="col-sm-4">
                                                            <div class="text-center">
                                                                <img alt="image" class="img-circle m-t-xs img-responsive" src="{{asset(avatar_image($user->avatar,200))}}" style="max-height: 200px;">
                                                                <div class="m-t-xs font-bold" style="height: 34px;max-height: 34px;">{{{$user->occupation or '外星外交行政官'}}}</div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="col-sm-8">
                                                        <p class="user_profile">
                                                            <span class="user_profile_handle"><a href="javascript:;" class="user_profile_edit btn btn-info" title="恢复" onclick="recoveryDel('user',{{$user->id}})"><i class="fa fa-hand-o-right"></i></a>
                                                            </span>
                                                        </p>
                                                        <h3><strong>{{{$user->nickname or $user->name}}}</strong></h3>
                                                        <p><i class="fa fa-map-marker"></i> {{{$user->address or '地球联邦特别行政区'}}}</p>
                                                        <address>
                                                            <strong><i class="fa fa-globe"></i> {{{$user->company or '火星行政局'}}}</strong><br>
                                                            E-mail：<span class="user_email">{{$user->email}}</span><br>
                                                            Weibo：<a class="weibo" href="{{{$user->weibo_link or '#'}}}" @if(!empty($user->weibo_link)) target="_blank" @endif>{{{$user->weibo_name or '无名氏'}}}</a><br>
                                                            GitHub：<a class="github" href="{{{$user->github_url or '#'}}}" @if(!empty($user->github_url)) target="_blank" @endif>{{{$user->github_name or '不告诉你'}}}</a><br>
                                                            WebSide：<a class="webside" href="{{{$user->website or '#'}}}" @if(!empty($user->website)) target="_blank" @endif>{{{$user->website or '加友链么？'}}}</a><br>
                                                            <abbr title="QQ号">QQ:</abbr> <span class="user_qq">{{$user->qq}}</span><br>
                                                            <strong>关于：</strong><br>
                                                            <p class="user_descript" title="{{$user->description}}">{{{$user->description or '害羞、傲娇的他或她未给你任何描述哦！'}}}</p>
                                                        </address>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                {!! $user_info->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $('.contact-box').each(function () {
            animationHover(this, 'pulse');
        });
    });
    $('.user_profile_info').mouseenter(function(){
        $('.user_profile_handle').hide();
        $(this).find('.user_profile_handle').show();
    });
    $('.user_profile_info').mouseleave(function(){
        $('.user_profile_handle').hide();
    });
</script>
@endsection