@extends('layouts.base')

@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('imgs/album.css')}}">
@stop

@section('content')
<div class="am-g am-g-fixed blog-fixed blog-content">
    <div class="am-u-sm-12">
        <div id="outer_container"> 
            <div id="customScrollBox"> 
                <div class="container"> 
                    <div class="content"> 
                        <h1>相册壁纸欣赏
                            <br /> 
                            <span class="light">
                                <span class="grey"> 
                                    <span class="s36">带侧边栏缩略图列表</span> 
                                </span> 
                            </span> 
                        </h1> 
                        <p>支持鼠标向左移动显示侧边栏</p> 
                        <div id="toolbar"></div> 
                        <div class="clear"></div> 
                        <a href="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_lucernarium.jpg')}}" class="thumb_link"> 
                            <span class="selected"></span> 
                            <img src="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_lucernarium_thumb.jpg')}}" title="Supremus Lucernarium" alt="Supremus Lucernarium" class="thumb" />
                        </a>
                        <a href="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk.jpg')}}" class="thumb_link"> 
                            <span class="selected"></span> 
                            <img src="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk_thumb.jpg')}}" title="Supremus Lucernarium" alt="Supremus Lucernarium" class="thumb" />
                        </a>
                        <a href="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk.jpg')}}" class="thumb_link> 
                            <span class="selected"></span> 
                            <img src="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk_thumb.jpg')}}" title="Supremus Lucernarium" alt="Supremus Lucernarium" class="thumb" />
                        </a>
                        <a href="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk.jpg')}}" class="thumb_link> 
                            <span class="selected"></span> 
                            <img src="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk_thumb.jpg')}}" title="Supremus Lucernarium" alt="Supremus Lucernarium" class="thumb" />
                        </a>
                        <a href="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk.jpg')}}" class="thumb_link> 
                            <span class="selected"></span> 
                            <img src="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk_thumb.jpg')}}" title="Supremus Lucernarium" alt="Supremus Lucernarium" class="thumb" />
                        </a>
                        <a href="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk.jpg')}}" class="thumb_link> 
                            <span class="selected"></span> 
                            <img src="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_dk_thumb.jpg')}}" title="Supremus Lucernarium" alt="Supremus Lucernarium" class="thumb" />
                        </a>
                        <p class="clear"></p> 
                        <p>&nbsp;</p> 
                    </div> 
                </div> 
                <div id="dragger_container"> 
                    <div id="dragger"></div> 
                </div> 
            </div> 
        </div> 
        <div id="bg"> 
            <img src="{{asset('imgs/space/Universe_and_planets_digital_art_wallpaper_lucernarium.jpg')}}" title="Supremus Lucernarium" id="bgimg" /> 
            <div id="preloader"> 
                <img src="{{asset('imgs/ajax-loader_dark.gif')}}" width="32" height="32" align="absmiddle" />加载中...
            </div> 
            <div id="nextimage_tip">点击加载下一张</div> 
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript" src="{{ asset('/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/jquery.easing.1.3.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jquery.mousewheel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/album.js')}}"></script>
@stop