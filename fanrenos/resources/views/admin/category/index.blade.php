@extends('admin.layouts.base') @section('title','分类列表') @section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="{{url('/dashboard/category/recycle/index')}}" class="btn btn-success btn-md">
                <i class="fa fa-trash-o"></i> 回收站<span style="color: #EC4758;">@if($soft>0)（{{$soft}}）@endif</span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('admin.partials.errors') @include('admin.partials.success')
            <div class="panel-heading">
                <h3 class="panel-title">分类列表</h3>
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
                        <i class="fa fa-question-circle fa-lg"></i> 你确定要删除该分类么?
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
</div>
@stop @section('js')
<script>
$(function() {
    initTable();
    $(document).on('click', '.delBtn', function() {
        var id = $(this).attr('data-id');
        var u = "{{ url('dashboard/category') }}" + '/' + id;
        $('#modal-delete').find('form').prop('action', u);
    });
});

function initTable() {
    var requestUrl = "{{url('dashboard/category/index_table')}}";
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
        search: true, //是否显示表格搜索，此搜索是客户端搜索，不会进服务端
        showColumns: true, //是否显示所有的列  
        showRefresh: true, //是否显示刷新按钮  
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
            title: '分类名称',
            field: 'name',
            align: 'left',
            valign: 'middle',
        }, {
            title: '分类路由',
            field: 'path',
            align: 'center',
            valign: 'middle',
        }, {
            title: '描述',
            field: 'description',
            align: 'center',
            valign: 'middle'
        }, {
            title: '创建时间',
            field: 'created_at',
            align: 'center',
            sortable: true,
            valign: 'middle'
        }, {
            title: '更新时间',
            field: 'updated_at',
            align: 'center',
            sortable: true,
            valign: 'middle'
        }, {
            title: '文章数量',
            field: 'article_count',
            align: 'center',
            sortable: true,
            valign: 'middle'
        }, {
            title: '操作',
            field: '#',
            align: 'center',
            valign: 'middle',
            formatter: function(value, row, index) {
                var d = '<a href="javascript:;" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger delBtn"><i class="fa fa-times-circle"></i> 删除</a>';
                var up = '<a href="{{url('/dashboard/category')}}/'+row.id+'/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> 编辑</a>';
                return up + d;
            }
        }]
    });
}
</script>
@stop