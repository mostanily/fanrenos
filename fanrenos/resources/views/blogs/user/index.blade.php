@extends('layouts.base')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/sinaFaceAndEffec.css')}}" />
<style type="text/css">
    .face-icon{margin-right: 8px;cursor: pointer;}
</style>
@stop
@section('content')
    @include('blogs.user.particals.info')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('Recent Comments') }}</div>

                    @include('blogs.user.particals.comments')

                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sinaFaceAndEffec.js')}}"></script>
<script type="text/javascript">
    window.onload = function(){
        $('li.list-group-item').each(function(){
            var inputText = $(this).find('.comment_content').html();
            $(this).find('.comment_content').html(AnalyticEmotion(inputText));
        });
    }
</script>
@stop