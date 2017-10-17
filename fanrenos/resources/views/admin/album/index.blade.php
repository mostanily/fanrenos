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
    initTable();

    $(document).on('click', '.delBtn', function() {
        var id = $(this).attr('data-id');
        var u = "{{ url('dashboard/album') }}" + '/' + id;
        $('#modal-delete').find('form').prop('action', u);
    });
    $(document).on('click', '.upload_album', function() {
        var u = "{{ url('/dashboard/album/update_info') }}";
        $('#modal-upload-album').find('form').prop('action', u);
    });
});
function initTable() {
    var requestUrl = "{{url('dashboard/album/index_table')}}";
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
            title: '图片名称',
            field: 'name',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '文件类型',
            field: 'mime',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '图像',
            field: 'mime_type',
            align: 'center',
            valign: 'middle',
            formatter: function(value,row,index){
                return '<img src="'+row.show_img+'" onclick="preview_image(\''+row.full_img+'\')">';
            }
        }, {
            title: '更新时间',
            field: 'updated_at',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '操作',
            field: '#',
            align: 'center',
            valign: 'middle',
            formatter: function(value, row, index) {
                return '<a href="javascript:;" data-id="'+row.id+'" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger delBtn"><i class="fa fa-times-circle"></i> 删除</a>';
            }
        }]
    });
}
</script>
@stop