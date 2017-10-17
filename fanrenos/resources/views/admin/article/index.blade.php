@extends('admin.layouts.base')

@section('title','文章列表')

@section('content')
    <div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="{{url('/dashboard/article/recycle/index')}}" class="btn btn-success btn-md">
                <i class="fa fa-trash-o"></i> 回收站<span style="color: #EC4758;">@if($soft>0)（{{$soft}}）@endif</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            @include('admin.partials.errors')
            @include('admin.partials.success')
            <div class="panel-heading">
                <h3 class="panel-title">文章列表</h3>
            </div>
            <div class="text-left">
                <button type="button" class="btn btn-info btn-sm" id="all_select" style="margin-bottom: 5px;">全选</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="batchDel('article')" style="margin: 0px 0px 5px 5px;">批量删除</button>
            </div>
            <table id="normal-table"></table>
        </div>
    </div>

</div>
@stop

@section('js')
<script>
$(function() {
    initTable();
});
function initTable() {
    var requestUrl = "{{url('dashboard/article/index_table')}}";
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
                var d = '<a href="{{url('/blog')}}/'+row.slug+'" class="btn btn-xs btn-warning" target="_blank"><i class="fa fa-eye"></i> 预览</a>';
                var up = '<a href="{{url('/dashboard/article')}}/'+row.id+'/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> 编辑</a>';
                return up + d;
            }
        }]
    });
}
</script>
@stop