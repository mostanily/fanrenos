@extends('admin.layouts.base')

@section('css')
    <link href="{{asset('/assets/pickadate/themes/default.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/pickadate/themes/default.date.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/pickadate/themes/default.time.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/selectize/css/selectize.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('markdown/css/bootstrap-markdown.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/drp.css')}}" />
@stop

@section('title','编辑评论')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">编辑评论</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')
                    @include('admin.partials.success')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('dashboard/comment') }}/{{$comment->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">

                        @include('admin.comment._form')

                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
                                    <button type="submit" class="btn btn-success btn-lg" name="action" value="finished">
                                        <i class="fa fa-floppy-o"></i>
                                            保存 - 返回
                                    </button>
                                    <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#modal-delete">
                                        <i class="fa fa-times-circle"></i>
                                        删除
                                    </button>
                                    <button type="button" class="btn btn-default btn-lg" onclick="back_btn()">
                                        <i class="fa fa-reply-all"></i>
                                        返回
                                    </button>
                                </div>
                            </div>
                        </div>
 
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- 确认删除 --}}
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">请确认</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        你确定要删除该篇评论么?
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ url('dashboard/comment') }}/{{$comment->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i> Yes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<!-- simditor -->
<script type="text/javascript" src="{{asset('markdown/js/markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('markdown/js/to-markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('markdown/js/bootstrap-markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('markdown/js/bootstrap-markdown.zh.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dropzone.js')}}"></script>
<script>
    var u = "{{url('/uploads/markdown_image')}}";
    $('#content').markdown({
        autofocus:true,
        iconlibrary: 'fa',
        language:'zh',
        dropZoneOptions: {
            paramName:'markdownImage',
            maxFilesize: 4,//M
            uploadMultiple:false,
            createImageThumbnails:true,
            url:u,
        }
    });
</script>
<script src="{{asset('/assets/pickadate/picker.js')}}"></script>
<script src="{{asset('/assets/pickadate/picker.date.js')}}"></script>
<script src="{{asset('/assets/pickadate/picker.time.js')}}"></script>
<script src="{{asset('/assets/selectize/js/selectize.min.js')}}"></script>
@stop