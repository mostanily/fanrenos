@extends('admin.layouts.base')

@section('title','编辑友链')
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
                    <h3 class="panel-title">编辑友链</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')
                    @include('admin.partials.success')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('dashboard/link') }}/{{$id}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">

                        @include('admin.link._form')

                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-3">
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
                        你确定要删除该友链么?
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ url('dashboard/link') }}/{{$id}}">
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