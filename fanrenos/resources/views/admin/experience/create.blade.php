@extends('admin.layouts.base')

@section('title','添加经历')
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
                            <h3 class="panel-title">添加新经历</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')
                            <form class="form-horizontal comment_form" role="form" method="POST" action="{{url('/dashboard/experience/')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @include('admin.experience._form')
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            添加
                                        </button>
                                        <button type="button" onclick="back_btn()" class="btn btn-default">
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