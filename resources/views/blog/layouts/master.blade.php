<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="{{ $meta_description }}">
  <meta name="author" content="{{ config('blog.author') }}">

  <title>{{ $title or config('blog.title') }}</title>
  <link href="{{asset('css/bootstrap.min.css')}}" rel='stylesheet' type='text/css' />
  <!-- Custom Theme files -->
  <link href="{{asset('css/useso/css.css')}}" rel='stylesheet' type='text/css'>
  {{-- Styles --}}
  <link href="{{asset('/assets/clean-blog/css/clean-blog.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/markdown/styles/monokai-sublime.css')}}">
  <link rel="stylesheet" href="{{asset('/css/mydefault.css')}}">
  @yield('styles')

  {{-- HTML5 Shim and Respond.js for IE8 support --}}
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
@include('blog.partials.page-nav')

@yield('page-header')
@yield('content')

@include('blog.partials.page-footer')
<!-- jQuery 2.2.3 -->
<script src="{{asset('/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>  

<!-- Bootstrap 3.3.6 -->
<script src="{{asset('/bootstrap/js/bootstrap.min.js')}}"></script>
{{-- Scripts --}}
<script src="{{asset('/assets/clean-blog/js/clean-blog.min.js')}}"></script>
<script src="{{asset('/assets/clean-blog/js/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('/markdown/highlight.pack.js')}}"></script>
<script>hljs.initHighlightingOnLoad();</script>
<script src="{{asset('/js/vlstat.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  var now=new Date()
  fixDate(now)
  now.setTime(now.getTime()+365 * 24 * 60 * 60 * 1000)
  var visits = getCookie("counter")
  if(!visits)
  {
   visits=1;
  }  
  else
  {
   visits=parseInt(visits)+1;
  }  
  setCookie("counter", visits, now)
  document.write("您是到访的第" + visits + "位用户！")

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
</script>
@yield('scripts')

</body>
</html>