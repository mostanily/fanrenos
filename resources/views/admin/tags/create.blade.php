@extends('admin.layouts.base')

@section('title','添加标签')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">新标签</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{url('/dashboard/tag')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">标签</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="tag" id="tag" value="{{ $tag }}" autofocus>
                                </div>
                            </div>

                            @include('admin.tags._form')

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        保存
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

@stop