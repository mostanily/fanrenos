@extends('layouts.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('css/personer.css')}}">
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-timeline">
                @if(!$experiences->isEmpty())
                    @foreach($experiences as $experience)
                    <div class="timeline">
                        <div class="timeline-content">
                            <div class="circle"><span><i class="{{$experience->icon[1]}}"></i></span></div>
                            <div class="content">
                                <span class="year">{{$experience->year}}</span>
                                <h4 class="title">{{$experience->title}}</h4>
                                {!! $experience->content_html !!}
                                <div class="icon"><span></span></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="timeline">
                        <div class="timeline-content">
                            <div class="circle"><span><i class="am-icon-life-bouy"></i></span></div>
                            <div class="content">
                                <span class="year">通向未知的年代</span>
                                <h4 class="title">无题</h4>
                                <p>还未进行更新，暂时还没想好要说什么。暂时先放在这，以后有时间了再来更新了！</p>
                                <p>我不想成为一个庸俗的人。十年百年后，当我们死去，质疑我们的人同样死去，后人看到的是裹足不前、原地打转的你，还是一直奔跑、走到远方的我？</p>
                                <div class="icon"><span></span></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop