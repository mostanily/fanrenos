@extends('admin.layouts.base')

@section('title','音乐列表')

@section('content')
    <div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#modal-upload-one-music" class="btn btn-default btn-md upload_one_music" title="服务器限制，暂时不可用">
                <i class="fa fa-upload"></i> 添加新单曲
            </a>
            <a href="{{url('/dashboard/music/deal_image')}}" class="btn btn-primary btn-md">
                <i class="fa fa-crop"></i> 压缩处理图片
            </a>
            <a href="{{url('/dashboard/music/update_info')}}" class="btn btn-info btn-md">
                <i class="fa fa-upload"></i> 更新音乐
            </a>
            <a href="{{url('/dashboard/music/recycle/index')}}" class="btn btn-success btn-md">
                <i class="fa fa-trash-o"></i> 回收站<span style="color: #EC4758;">@if($soft>0)（{{$soft}}）@endif</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            @include('admin.partials.errors')
            @include('admin.partials.success')
            <div class="panel-heading">
                <h3 class="panel-title">音乐列表</h3>
            </div>
            <div class="text-left">
                <button type="button" class="btn btn-info btn-sm" id="all_select" style="margin-bottom: 5px;">全选</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="batchDel('music')" style="margin: 0px 0px 5px 5px;">批量删除</button>
            </div>
            <table id="normal-table"></table>
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
                        你确定要删除该音乐么?
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

    <div class="modal fade" id="modal-upload" tabIndex="-1">
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
                        更新歌词
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="" enctype=multipart/form-data>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="page_image" class="col-md-3 control-label">
                                lrc歌词文件
                            </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" value="" name="lrc" required="">
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
    <div class="modal fade" id="modal-upload-one-music" tabIndex="-1">
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
                        添加新单曲
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="" enctype=multipart/form-data>
                        <div class="form-group">
                            <label for="page_image" class="col-md-3 control-label">
                                lrc歌词文件
                            </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" value="" name="lrc" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_image" class="col-md-3 control-label">
                                专辑封面图
                            </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" value="" name="album">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_image" class="col-md-3 control-label">
                                歌曲文件
                            </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" value="" name="music-file" required="">
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
    initTable();

    $(document).on('click', '.delMusic', function() {
        var id = $(this).attr('data-id');
        var u = "{{ url('dashboard/music') }}" + '/' + id;
        $('#modal-delete').find('form').prop('action', u);
    });
    $(document).on('click', '.upload_lrc', function() {
        var id = $(this).attr('data-id');
        var u = "{{ url('dashboard/music/lrc_upload') }}" + '/' + id;
        $('#modal-upload').find('form').prop('action', u);
    });
    $(document).on('click', '.upload_one_music', function() {
        var u = "{{ url('/dashboard/music/store_one') }}";
        $('#modal-upload-one-music').find('form').prop('action', u);
    });
});
function initTable() {
    var requestUrl = "{{url('dashboard/music/index_table')}}";
    var $table = $('#normal-table');
    $table.bootstrapTable({
        url: requestUrl,
        method: 'get', //请求方式（*）
        striped: true, //是否显示行间隔色  
        cache: false, //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）  
        pagination: true, //是否显示分页（*）
        sortOrder: "asc", //排序方式  
        pageNumber: 1, //初始化加载第一页，默认第一页
        pageSize: 20, //每页的记录行数（*）
        pageList: [10, 20, 50, 100], //可供选择的每页的行数（*）  
        search: true,      //是否显示表格搜索，此搜索是客户端搜索，不会进服务端
        showColumns: true,     //是否显示所有的列  
        showRefresh: true,     //是否显示刷新按钮  
        minimumCountColumns: 2, //最少允许的列数  
        clickToSelect: true, //是否启用点击选中行  
        uniqueId: "id", //每一行的唯一标识，一般为主键列  
        showToggle: true, //是否显示详细视图和列表视图的切换按钮  
        columns: [{
            title: '多选框',
            field: 'select_input',
            align: 'center',
            valign: 'middle',
            formatter: function(value, row, index){
                return '<label><input class="all_select" type="checkbox" value="'+row.id+'"></label>';
            }
        }, {
            title: 'ID',
            field: 'id',
            visible: false,
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '音乐名称',
            field: 'title',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '演唱者',
            field: 'artist',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '文件类型',
            field: 'mime_type',
            align: 'center',
            valign: 'middle'
        }, {
            title: '文件大小',
            field: 'size',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '播放时长',
            field: 'play_time',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '上传时间',
            field: 'created_at',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '操作',
            field: '#',
            align: 'center',
            valign: 'middle',
            formatter: function(value, row, index) {
                var d = '<a href="javascript:;" data-id="'+row.id+'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger delMusic"><i class="fa fa-times-circle"></i> 删除</a>';
                var up = '<a href="javascript:;" data-id="'+row.id+'" data-toggle="modal" data-target="#modal-upload" class="btn btn-xs btn-info upload_lrc"><i class="fa fa-upload"></i> 更新歌词</a>';
                return up + d;
            }
        }]
    });
}
</script>
@stop