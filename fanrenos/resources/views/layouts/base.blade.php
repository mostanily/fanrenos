<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ $title or config('blog.title') }}</title>
<meta name="description" content="{{ $meta_description }}">
<meta name="author" content="{{ config('blog.author') }}">
<meta name="keywords" content="{{ config('blog.keywords') }}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="_token" content="{{ csrf_token() }}"/>
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<link rel="icon" type="image/ico" href="{{asset('favicon.ico')}}">
<meta name="mobile-web-app-capable" content="yes">
<link rel="icon" sizes="192x192" href="{{asset('favicon.ico')}}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="Amaze UI"/>
<link rel="apple-touch-icon-precomposed" href="{{asset('favicon.ico')}}">
<meta name="msapplication-TileImage" content="{{asset('favicon.ico')}}">
<meta name="msapplication-TileColor" content="#0e90d2">
{{-- <link href="{{asset('css/bootstrap.min.css')}}" rel='stylesheet' type='text/css' /> --}}
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
<link href="{{asset('css/style.min.css')}}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{asset('/markdown/styles/monokai-sublime.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/highlight.js/8.0/styles/monokai_sublime.min.css">
<link rel="stylesheet" href="{{asset('css/amazeui.min.css')}}">
<link rel="stylesheet" href="{{asset('css/app_amaze.css')}}">
<!-- //animation-effect -->
<style type="text/css">
    @media only screen and (max-width: 640px) {
        #modal-form>.modal-dialog{margin: 0 auto;margin-top: 50px;max-width: 320px;}
    }
</style>
@yield('css')
</head>
<body id="blog">
@include('layouts.mainHeader')
<!-- banner -->
@yield('banner')

<!-- content -->
@yield('content')

<div class="modal fade" id="modal-form" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 b-r">
                        <h3 class="m-t-none m-b">登录</h3>
                        <p>欢迎登录本站(⊙o⊙)</p>
                        <form role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>邮箱：</label>
                                <input type="email" name="email" placeholder="请输入邮箱" class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label>密码：</label>
                                <input type="password" name="password" placeholder="请输入密码" class="form-control" required="">
                            </div>
                            <div>
                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>登录</strong>
                                </button>
                                <label>
                                    <input type="checkbox" name="remember" checked="checked" class="i-checks">自动登录
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h4>还不是会员？</h4>
                        <p>您可以注册一个账户</p>
                        <p class="text-center">
                            <a href="{{url('register')}}" target="_blank"><i class="am-icon-sign-in" style="font-size: 150px;"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">提示</div>
        <div class="am-modal-bd">
        </div>
        <div class="am-modal-footer">
            <input type="hidden" id="url" value="">
            <input type="hidden" id="data" value="">
            <span class="am-modal-btn" >取消</span>
            <span class="am-modal-btn del_sure" >确定</span>
        </div>
    </div>
</div>
<div class="am-modal" id="modal-image-view" height="500">
    <div class="am-modal-dialog">
        <div class="am-modal-content">
            <div class="am-modal-bd">
                <img id="preview-image" src="" class="img-responsive">
            </div>
        </div>
    </div>
</div>

@include('layouts.mainFooter')

<!-- jQuery 2.2.3 -->
<!-- Bootstrap 3.3.6 -->
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
{{-- <script src="{{asset('/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{asset('/bootstrap/js/bootstrap.min.js')}}"></script> --}}
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
{{-- <script src="{{asset('/markdown/highlight.pack.js')}}"></script> --}}
<script src="https://cdn.bootcss.com/highlight.js/9.12.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
{{-- <script src="{{asset('js/amazeui.min.js')}}"></script> --}}
<script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script type="text/javascript">
$(function(){
    //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
    $(function () {
        $(window).scroll(function(){
            if ($(window).scrollTop()>100){
                $("#back-to-top").fadeIn(1500);
            }
            else
            {
                $("#back-to-top").fadeOut(1500);
            }
        });
        //当点击跳转链接后，回到页面顶部位置
        $("#back-to-top").click(function(){
            $('body,html').animate({scrollTop:0},1000);
            return false;
        });
    });
});

$('.del_sure').click(function(){
    var url = $('#url').val();
    var data = $('#data').val();
    $.ajax({
        url:url,
        type:"POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data:data,
        success:function(msg){
            if(msg.status=='success'){
                window.location.reload();
            }else{
                myalert('操作失败，可能是网络问题，可以联系管理员，请过会后重试！');
            }
        }
    });
});
function myalert(con,sure,url,data){
    if(sure=='make-sure'){
        $('#url').val(url);
        $('#data').val(data);
        $('.del_sure').addClass('am-modal-btn');
        $('.del_sure').show();
    }else{
        $('.del_sure').removeClass('am-modal-btn');
        $('.del_sure').hide();
    }
    $('#my-confirm').find('.am-modal-bd').html(con);
    $('#my-confirm').modal();
}
function preview_image(path) {
    $("#preview-image").attr("src", path);
    $('#modal-image-view').modal('open');
}
function toJump(url,target){
    if(target=='_blank'){
        window.open(url);
    }else{
        window.location.href = url;
    }
}
</script>
@yield('js')
</body>
</html>