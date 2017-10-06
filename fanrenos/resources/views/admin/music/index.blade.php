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
            <table id="posts-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th data-sortable="false" class="hidden-sm"></th>
                    <th style="text-align: center;">ID</th>
                    <th>音乐名称</th>
                    <th>演唱者</th>
                    <th>文件类型</th>
                    <th>文件大小</th>
                    <th>播放时长</th>
                    <th>上传时间</th>
                    <th data-sortable="false">操作</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($musics as $music)
                <tr>
                    <td>{!!$music->select_input!!}</td>
                    <td style="text-align: center;">{{ $music->id }}</td>
                    <td>{{ $music->title }}</td>
                    <td>{{ $music->artist}}</td>
                    <td>{{ $music->mime_type }}</td>
                    <td>{{ $music->size}}</td>
                    <td>{{ $music->play_time }}</td>
                    <td>{{ $music->created_at }}</td>
                    <td>
                        <a href="javascript:;" data-id="{{$music->id}}" data-toggle="modal" data-target="#modal-delete" class="btn btn-xs btn-danger delMusic">
                            <i class="fa fa-times-circle"></i> 删除
                        </a>
                        <a href="javascript:;" data-id="{{$music->id}}" data-toggle="modal" data-target="#modal-upload" class="btn btn-xs btn-info upload_lrc">
                            <i class="fa fa-upload"></i> 更新歌词
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
            order: [[3, "desc"]]
        });

        $(document).on('click','.delMusic',function(){
            var id = $(this).attr('data-id');
            var u = "{{ url('dashboard/music') }}"+'/'+id;
            $('#modal-delete').find('form').prop('action',u);
        });
        $(document).on('click','.upload_lrc',function(){
            var id = $(this).attr('data-id');
            var u = "{{ url('dashboard/music/lrc_upload') }}"+'/'+id;
            $('#modal-upload').find('form').prop('action',u);
        });
        $(document).on('click','.upload_one_music',function(){
            var u = "{{ url('/dashboard/music/store_one') }}";
            $('#modal-upload-one-music').find('form').prop('action',u);
        });
    });
</script>
@stop