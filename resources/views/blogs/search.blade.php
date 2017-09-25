@extends('layouts.base',[
    'title' => '搜索结果|'.$key,
    'meta_description' => config('blog.description'),
])

@section('content')
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed blog-content">
    <div class="am-u-md-8 am-u-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <h2>为您找到相关结果约{{$count}}个： <span class="text-navy">“{{$key}}”</span></h2>
                <small>搜索用时  (约{{$diff_time}}秒)</small>
                @if($count==0)
                    <div class="hr-line-dashed"></div>
                    <div class="search-result">
                        <p>没有搜索到结果哦，请重置搜索条件再试试！</p>
                    </div>
                @else
                    @foreach($posts as $post)
                        <div class="hr-line-dashed"></div>
                        <div class="search-result">
                            <h3><a href="{{url('/blog/'.$post->slug)}}">{{ $post->title }}</a></h3>
                            <a href="{{url('/blog/'.$post->slug)}}" class="search-link">{{url('/blog/'.$post->slug)}}</a>
                            <p><span class="am-icon-tags"> &nbsp;</span>{{$post->tag}}</p>
                            <p>{{$post->subtitle}}</p>
                        </div>
                    @endforeach
                @endif
                <div class="hr-line-dashed"></div>
                <div class="text-center">
                    {!! $posts->appends(['key'=>$key])->render() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- About Me -->
    @include('layouts.about_me')
</div>
@stop