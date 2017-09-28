@extends('layouts.base')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/xiami.css')}}">
<style type="text/css">
    .uk-overlay{overflow: hidden;margin-bottom: 0px; }
    .uk-overlay img{max-width: 200px;min-width: 190px;transition: all 0.6s;}
    #canvas1{max-width: 200px;min-width: 190px;}
    .uk-overlay img:hover{transform: scale(1.4);}
    .album-b-title{max-width: 200px;background: rgba(0,0,0,0.3);}
    .b-title{padding-left: 10px;padding-bottom: 5px;max-width: 100%;text-overflow: ellipsis;}
    .album-b-title a{display: block;margin: 0;line-height: 20px;text-overflow: ellipsis;padding-right: 15px;overflow: hidden;max-height: 24px;}
    .album-b-title .b-name{color: #F9F5F5;font-size: 14px;text-align: center;}
    .album-b-title .b-alb{color: #666;font-size: 12px;}
    .album-b-title .b-art{color: #666;font-size: 12px;}
    .album-b-title a:hover{color: #d8a868;}
    .list-icon-play{color: #d1d1d1;font-size: 24px;display: none;margin-right: 10px;}
    .iconfont{color: #d1d1d1;}
    .iconfont:hover{color: #d8a868;}
    .iconfont{position: absolute;right: 3px;bottom: 6px;}
    .lre-main-box{min-height: 400px;position: fixed;top: 10%;right: 20px;}
    .playerBox{height: 100px;position: fixed;left: 0px;bottom: 50px;}
    #musicTitle{font-size: 15px;font-weight: bold;margin-top: 40px;text-align: center;}
    #musicTitle p{font-size: 13px;text-align: center;margin: 1px 0px;}
    @media only screen and (max-width: 640px) {
        .playerBox{bottom: 20px;}
        .item-album{margin-bottom: 30px;}
        .lre-main-box {left: 47%;min-height: 200px;max-width: 160px;}
        .albumCover{display: none;}
        .album-b-title{max-width: 150px;}
        .uk-overlay img{max-width: 150px;min-width: 100px;}
        .mainOuther{padding-right: 10px;width: 150px;}
        #canvas1{max-width: 150px;min-width: 100px;}
        .bottom{height: 90px;}
        .playerWrap{width: 100%;padding-left:0px;padding-right: 0px;}
        .playerCon,.playInfo{width: 300px;position: initial;}
        .playerCon,.playInfo{height: 40px;}
        .vol{display: none;}
        .playInfo>div{position: initial;}
        .playInfo .trackInfo{overflow: hidden;}
        .duration{text-align: center;}
        .playerCon a{top: 0px;}
        .playerCon a.mode{top: 6px;}
    }
</style>
@stop

@section('content')

<div class="am-g am-g-fixed blog-fixed">
    <div class="am-u-md-10 am-u-sm-12" style="min-height: 400px;">
        <div class="am-article-hd" style="margin: 20px 0 40px 0;">
            <h1 class="am-article-title">音乐欣赏</h1>
            <audio id="audio" src="{{asset($path.$musics[0]->name)}}"></audio>
            <input id="def-path" type="hidden" value="{{asset($path)}}">
        </div>
        
        <div class="js-masonry" data-masonry-options='{ "itemSelector": ".item", "columnWidth": 240 }'>
            @foreach($musics as $music)
                <div class="item item-album" style="margin-bottom: 10px;">
                    <figure class="uk-overlay">
                        <a href="javascript:;">
                            <img src="{{page_image($music->image,'music','songs')}}" alt=""></a>
                    </figure>
                    <div class="album-b-title">
                        <div class="b-title">
                            <a href="javascript:;" class="b-name" title="{{$music->title}}">{{$music->title}}</a>
                            <a href="javascript:;" class="b-alb" title="{{$music->album}}">专辑：{{$music->album}}</a>
                            <a href="javascript:;" class="b-art" title="{{$music->artist}}">演唱：{{$music->artist}}</a>
                        </div>
                        <a href="javascript:;" data_path="{{$music->name}}" data-prev="{{$music->prev}}" data-next="{{$music->next}}" class="list-icon-play uk-animation-scale-up player_music">
                            <i class="iconfont am-icon-play-circle-o am-icon-sm"></i>
                        </a>
                        <div class="m_lyr" style="display: none;">{{$music->lrc}}</div>
                    </div>
                </div>
            @endforeach
        </div>
        {!! $musics->render() !!}
    </div>
    <div class="am-u-md-3 am-u-sm-12 lre-main-box">
        <div class="mainOuther">
            <div class="albumCover">
                <a href="javascript:;">
                    <img src="{{page_image($musics[0]->image,'music','songs')}}" id="canvas1">
                </a>
            </div>
            <div id="musicTitle"><span class="m-title">{{$musics[0]->title}}</span>
                <p class="m-album">专辑：{{$musics[0]->album}}</p>
                <p class="m-artist">演唱：{{$musics[0]->artist}}</p>
            </div>
            <div id="lyr"></div>
        </div>
    </div>
    <div class="am-u-md-12 am-u-sm-12 playerBox">
        <div class="bottom">
            <div class="playerWrap">
                <div class="playerCon">
                    <a href="javascript:;" class="pbtn prevBtn"></a>
                    <a href="javascript:;" class="pbtn playBtn" isplay="0"></a>
                    <a href="javascript:;" class="pbtn nextBtn"></a>
                    <a href="javascript:;" class="mode"></a>
                </div>
                <div class="playInfo">
                    <div class="trackInfo">
                        <a href="javascript:;" class="songName">{{$musics[0]->title}}</a>
                            -
                        <a href="javascript:;" class="songPlayer">{{$musics[0]->artist}}</a>
                    </div>
                    <div class="playerLength">
                        <div class="position">00:00</div>
                        <div class="progress">
                            <div class="pro1"></div>
                            <div class="pro2">
                                <a href="javascript:;" class="dian"></a>
                            </div> 
                        </div>
                        <div class="duration">{{$musics[0]->play_time}}</div>
                    </div>
                </div>
                <div class="vol">
                    <div class="volm">
                        <div class="volSpeaker"></div>
                        <div class="volControl">
                            <a href="javascript:;" class="dian2"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript" src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/mousewheel.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/scroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/xiami.js') }}"></script>
@stop