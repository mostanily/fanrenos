@extends('admin.layouts.base')

@section('title','相册列表')

@section('content')
    <div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#modal-upload-album" class="btn btn-default btn-md upload_album">
                <i class="fa fa-upload"></i> 添加新图片
            </a>
            <a href="{{url('/dashboard/album/update_info?uploadType=getAlbum')}}" class="btn btn-info btn-md">
                <i class="fa fa-upload"></i> 更新相册
            </a>
            <a href="{{url('/dashboard/album/recycle/index')}}" class="btn btn-success btn-md">
                <i class="fa fa-trash-o"></i> 回收站<span style="color: #EC4758;">@if($soft>0)（{{$soft}}）@endif</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            @include('admin.partials.errors')
            @include('admin.partials.success')
            <div class="panel-heading">
                <h3 class="panel-title">图片列表</h3>
            </div>
            <div class="text-left">
                <button type="button" class="btn btn-info btn-sm" id="all_select" style="margin-bottom: 5px;">全选</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="batchDel('album')" style="margin: 0px 0px 5px 5px;">批量删除</button>
            </div>
            <table id="posts-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th data-sortable="false" class="hidden-sm"></th>
                    <th style="text-align: center;">ID</th>
                    <th>图片名称</th>
                    <th>文件类型</th>
                    <th>图像</th>
                    <th>更新时间</th>
                    <th data-sortable="false">操作</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($albums as $album)
                <tr>
                    <td>{!!$album->select_input!!}</td>
                    <td style="text-align: center;">{{ $album->id }}</td>
                    <td>{{ $album->name }}</td>
                    <td>{{ $album->mime }}</td>
                    <td><img src="{{ page_image_size($album->name,150,'albums')}}" onclick="preview_image('{{ page_image_size($album->name,1000,'albums') }}')"></td>
                    <td>{{ $album->updated_at }}</td>
                    <td>
                        <a href="javascript:;" data-id="{{$album->id}}" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger delBtn">
                            <i class="fa fa-times-circle"></i> 删除
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
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
                        你确定要删除该文件么?
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="">
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
    <div class="modal fade" id="modal-upload-album" tabIndex="-1">
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
                        添加新图片
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="" enctype=multipart/form-data>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="page_image" class="col-md-3 control-label">
                                图片（可批量）
                            </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" value="" name="albumImage[]" required="" multiple="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">
                            <i class="fa fa-upload"></i> 上传
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(function() {
        $("#posts-table").DataTable({
            language: {
                "sProcessing": "处理中...",
                "sLengthMenu": "显示 _MENU_ 项结果",
                "sZeroRecords": "没有匹配结果",
                "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix": "",
                "sSearch": "搜索:",
                "sUrl": "",
                "sEmptyTable": "表中数据为空",
                "sLoadingRecords": "载入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上页",
                    "sNext": "下页",
                    "sLast": "末页"
                },
                "oAria": {
                    "sSortAscending": ": 以升序排列此列",
                    "sSortDescending": ": 以降序排列此列"
                }
            },
            order: [[5, "desc"]]
        });

        $(document).on('click','.delBtn',function(){
            var id = $(this).attr('data-id');
            var u = "{{ url('dashboard/album') }}"+'/'+id;
            $('#modal-delete').find('form').prop('action',u);
        });
        $(document).on('click','.upload_album',function(){
            var u = "{{ url('/dashboard/album/update_info') }}";
            $('#modal-upload-album').find('form').prop('action',u);
        });
    });
</script>
@stop