@extends('admin.layouts.base') @section('title','添加分类') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">新分类</h3>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('dashboard/category') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> @include('admin.category._form')
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-disk-o"></i> 保存
                                    </button>
                                    <button type="button" class="btn btn-default btn-lg" onclick="back_btn()">
                                        <i class="fa fa-reply-all"></i> 返回
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