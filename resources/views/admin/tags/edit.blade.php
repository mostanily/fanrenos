@extends('admin.layouts.base')

@section('title','编辑标签')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">标签编辑</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')
                    @include('admin.partials.success')

                    <form class="form-horizontal" role="form" method="POST" action="{{url('/dashboard/tag')}}/{{ $id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{ $id }}">

                        <div class="form-group">
                            <label for="tag" class="col-md-3 control-label">标签</label>
                            <div class="col-md-3">
                                <p class="form-control-static">{{ $tag }}</p>
                            </div>
                        </div>

                        @include('admin.tags._form')

                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <i class="fa fa-save"></i>
                                    保存
                                </button>
                                <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modal-delete">
                                    <i class="fa fa-times-circle"></i>
                                    删除
                                </button>
                                <button type="button" class="btn btn-default btn-md" onclick="back_btn()">
                                    <i class="fa fa-reply-all"></i>
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
                    你确定要删除该标签么?
                </p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{url('/dashboard/tag')}}/{{ $id }}">
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

@stop