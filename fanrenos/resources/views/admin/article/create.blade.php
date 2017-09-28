@extends('admin.layouts.base')

@section('title','添加文章')
@section('css')
    <link href="{{asset('/assets/pickadate/themes/default.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/pickadate/themes/default.date.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/pickadate/themes/default.time.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/selectize/css/selectize.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('markdown/css/bootstrap-markdown.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/drp.css')}}" />
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">新文章</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('dashboard/article') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('admin.article._form')

                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-disk-o"></i>
                                        保存
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
    $(function() {
        $("#publish_date").pickadate({
            format: "mmm-d-yyyy"
        });
        $("#publish_time").pickatime({
            format: "h:i A"
        });
        $("#tags").selectize({
            create: true
        });
    });
</script>
<script src="{{asset('/assets/pickadate/picker.js')}}"></script>
<script src="{{asset('/assets/pickadate/picker.date.js')}}"></script>
<script src="{{asset('/assets/pickadate/picker.time.js')}}"></script>
<script src="{{asset('/assets/selectize/js/selectize.min.js')}}"></script>
@stop