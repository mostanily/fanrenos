@extends('layouts.base')

@section('banner')
<!-- banner start -->
@if(!empty($bannerPost))
<div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-article-margin am-hide-sm-only">
    <div data-am-widget="slider" class="am-slider am-slider-b1" data-am-slider='{&quot;controlNav&quot;:false}' >
        <ul class="am-slides">
            @foreach ($bannerPost as $post)
            <li>
                <img src="{{page_image($post->page_image,'banner')}}">
                <div class="blog-slider-desc am-slider-desc ">
                    <div class="blog-text-center blog-slider-con">
                        <span><a href="" class="blog-color">Article &nbsp;</a></span>               
                        <h1 class="blog-h-margin"><a href="{{$post->url($tag)}}">{{ $post->title }}</a></h1>
                        <p>
                        @if ($post->subtitle)
                            <h3>{{ $post->subtitle }}</h3>
                        @else
                            那时候刚好下着雨，柏油路面湿冷冷的，还闪烁着青、黄、红颜色的灯火。
                        @endif
                        </p>
                        <span>{{ $post->published_at->format('F j, Y') }}</span>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<!-- banner end -->
@stop

@section('content')
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed">
    <div class="am-u-md-8 am-u-sm-12">
        @if(!$posts->isEmpty())
        @foreach ($posts as $post)
            <article class="am-g blog-entry-article">
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <img src="{{page_image($post->page_image,'post')}}" alt="" class="am-u-sm-12" onclick="preview_image('{{ page_image($post->page_image,"post") }}')" style="max-height: 210px;">
                </div>
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <span>Post By</span>
                    <span><a href="javascript:;" class="blog-color"> @Mostanily &nbsp;</a></span>
                    @if($post->view_count>0)
                        <span data-am-popover="{content: '浏览' ,trigger: 'hover focus'}" style="margin-left: 20px;"><i class="am-icon-eye"></i> {{$post->view_count}} </span>
                    @endif
                    <br>
                    <span data-am-popover="{content: '发布于 {{$post->published_at}}' ,trigger: 'hover focus'}" >On {{ $post->published_at->format('F j, Y') }}</span>
                    <span>
                        @if ($post->tags->count())
                            in {!! join(', ', $post->tagLinks()) !!}
                        @endif
                    </span>
                    <h1><a href="{{ $post->url($tag) }}">{{ $post->title }}</a></h1>
                    @if ($post->subtitle)
                        <h3 style="margin: 0px;">{{ $post->subtitle }}</h3>
                    @endif
                    <p>{{$post->content_raw}}</p>
                    <p><a href="" class="blog-continue">continue reading</a></p>
                </div>
            </article>
        @endforeach
        <ul class="am-pagination">
            @if ($reverse_direction)
                @if ($posts->currentPage() > 1)
                    <li class="am-pagination-prev">
                        <a href="{!! $posts->url($posts->currentPage() - 1) !!}">
                            <i class="fa fa-long-arrow-left fa-lg"></i>
                            上一篇 {{ $tag->tag }} 文章
                        </a>
                    </li>
                @endif
                @if ($posts->hasMorePages())
                    <li class="am-pagination-next">
                        <a href="{!! $posts->nextPageUrl() !!}">
                            下一篇 {{ $tag->tag }} 文章
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </li>
                @endif
            @else
                @if ($posts->currentPage() > 1)
                      <li class="am-pagination-prev">
                        <a href="{!! $posts->url($posts->currentPage() - 1) !!}">
                            <i class="fa fa-long-arrow-left fa-lg"></i>
                            新 {{ $tag ? $tag->tag : '' }} 文章
                        </a>
                      </li>
                @endif
                @if ($posts->hasMorePages())
                    <li class="am-pagination-next">
                        <a href="{!! $posts->nextPageUrl() !!}">
                            旧 {{ $tag ? $tag->tag : '' }} 文章
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
        @else
            <article class="am-g blog-entry-article">
                <div class="am-u-lg-12 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <p>该标签下暂时还没有文章，正在加班加点赶工呢！</p>
                </div>
            </article>
        @endif
    </div>
    <!-- About Me -->
    @include('layouts.about_me')
</div>
@stop