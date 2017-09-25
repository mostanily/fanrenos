@extends('admin.layouts.base')

@section('title','编辑经历')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('markdown/css/bootstrap-markdown.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/drp.css')}}" />
@stop

@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">编辑经历信息</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')
                            <form class="form-horizontal comment_form" role="form" method="POST" action="{{url('/dashboard/experience/')}}/{{$id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                @include('admin.experience._form')
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fa fa-plus-circle"></i>
                                            保存
                                        </button>
                                        <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#modal-delete">
                                            <i class="fa fa-times-circle"></i>
                                            删除
                                        </button>
                                        <button type="button" onclick="back_btn()" class="btn btn-default btn-lg">
                                            <i class="fa  fa-reply-all"></i>
                                            返回
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            你确定要删除该经历么?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ url('dashboard/experience') }}/{{$id}}">
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
<script type="text/javascript" src="{{asset('/plugins/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4.3.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/plugins/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.js')}}"></script>
<script type="text/javascript" src="{{asset('markdown/js/markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('markdown/js/to-markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('markdown/js/bootstrap-markdown.js')}}"></script>
<script type="text/javascript" src="{{asset('markdown/js/bootstrap-markdown.zh.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dropzone.js')}}"></script>
<script type="text/javascript">
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
@stop