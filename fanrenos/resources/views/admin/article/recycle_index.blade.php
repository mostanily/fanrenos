@extends('admin.layouts.base')

@section('title','已删除文章列表')

@section('content')
    <div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="{{url('/dashboard/article/index')}}" class="btn btn-success btn-md">
                <i class="fa fa-mail-reply-all"></i> 返回文章列表
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            @include('admin.partials.errors')
            @include('admin.partials.success')
            <div class="panel-heading">
                <h3 class="panel-title">已经删除文章列表</h3>
            </div>
            <table id="normal-table"></table>
        </div>
    </div>
</div>
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确认要彻底删除此篇文章么？
                    </p>
                </div>
                <div class="modal-footer">
                    <form class="deleteForm" method="POST" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="button" class="btn btn-default del_back_btn" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger del_sure_btn">
                            <i class="fa fa-times-circle"></i>确认
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
$(document).on('click', ".realDel", function() {
    var id = $(this).attr('attr');
    var d_u = "{{url('/dashboard/article/real_delete')}}" + '/' + id;
    $('.lead').text('确认要彻底删除此篇文章么？');
    $('.deleteForm').attr('action', d_u);
    $("#modal-delete").modal();
});

$(function() {
    initTable();
});
function initTable() {
    var requestUrl = "{{url('dashboard/article/recycle_index_table')}}";
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
            title: 'ID',
            field: 'id',
            visible: false,
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '发布时间',
            field: 'published_at_format',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '标题',
            field: 'title',
            align: 'center',
            valign: 'middle',
            sortable: true,
        }, {
            title: '副标题',
            field: 'subtitle',
            align: 'center',
            valign: 'middle'
        }, {
            title: '操作',
            field: '#',
            align: 'center',
            valign: 'middle',
            formatter: function(value, row, index) {
                var d = '<a href="javascript:;" attr="'+row.id+'" class="btn btn-xs btn-danger realDel"><i class="fa fa-trash"></i> 彻底删除</a>';
                var up = '<a href="javascript:;" class="btn btn-xs btn-info" onclick="recoveryDel(\'article\','+row.id+')"><i class="fa fa-hand-o-right"></i> 恢复</a>';
                return up + d;
            }
        }]
    });
}
</script>
@stop