<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="{{ config('blog.description') }}">
<meta name="author" content="{{ config('blog.author') }}">
<meta name="keywords" content="{{ config('blog.keywords') }}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>{{ $title or config('blog.title') }}| @yield('title')</title>
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<link rel="icon" type="image/ico" href="{{asset('favicon.ico')}}">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="Amaze UI"/>
<link rel="apple-touch-icon-precomposed" href="{{asset('images/app-icon72x72@2x.png')}}">
<meta name="msapplication-TileImage" content="{{asset('images/app-icon72x72@2x.png')}}">
<meta name="msapplication-TileColor" content="#0e90d2">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/public.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/login_on.css')}}" tppabs="css/style.css" />
<style type="text/css">
    .log-footer,.log-footer a{color: #fff;}
    .log-footer a:hover{color: #10D4AF;}
    body{height:100%;background:#16a085;overflow:hidden;}
    canvas{z-index:-1;position:absolute;}
</style>
</head>
<body>
    @yield('content')

    <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/amazeui/2.7.2/js/amazeui.min.js"></script>
    <script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>
    <script src="{{asset('js/Particleground.js')}}" tppabs="{{asset('js/Particleground.js')}}"></script>
    @yield('js')
    <script type="text/javascript">
        $(document).ready(function() {
            //粒子背景特效
            $('body').particleground({
                dotColor: '#5cbdaa',
                lineColor: '#5cbdaa'
            });
        });
        @if (count($errors) > 0)
            <?php
                $errors_str = '';
                foreach($errors->all() as $error){
                    $errors_str .= $error.'<br>';
                }
            ?>
            var error = "{!!$errors_str!!}";
            layer.open({
                type: 1,
                skin: 'layui-layer-lan', //样式类名
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                area: ['400px', '120px'],
                shadeClose: true, //开启遮罩关闭
                content: '<p style="margin:0px;text-align:center;">'+error+'</p>',
            });
        @endif
        function toJump(url,target){
            if(target=='_blank'){
                window.open(url);
            }else{
                window.location.href = url;
            }
        }
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?7e53f041994830ce53d57fb718e5d98a";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
    </script>
</body>
</html>
