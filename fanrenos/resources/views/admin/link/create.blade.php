@extends('admin.layouts.base')

@section('title','添加友链')
@section('css')
<style type="text/css">
    .hidden_upload_button{display: none;}
</style>
@stop
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">新友链</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('dashboard/link') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('admin.link._form')

                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-3">
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
<script type="text/javascript">
    $(function(){
        $('.need_local_image').click(function(){
            if($('.upload_local_image').hasClass('hidden_upload_button')){
                $('.upload_local_image').removeClass('hidden_upload_button');
            }else{
                $('.upload_local_image').addClass('hidden_upload_button');
            }
        });
    });
</script>
@stop