@extends('admin.layouts.base')

@section('title','控制面板')
@section('css')
<link href="{{asset('css/style_grid.css')}}" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
    .btn-default{background-color: #f4f4f4;color: #444;border-color: #ddd;}
    .btn-outline{color: inherit;background-color: transparent;}
</style>
@endsection

@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">网站信息预览</h3>
                        </div>
                        <div class="panel-body">
                            <div class="agile_top_w3_grids">
                                <ul class="ca-menu">
                                    <li>
                                        <a href="{{url('dashboard/user')}}">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <div class="ca-content">
                                                <h4 class="ca-main">{{number_format($user_count)}}</h4>
                                                <h3 class="ca-sub">用户数</h3>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                          <i class="fa fa-eye" aria-hidden="true"></i>
                                            <div class="ca-content">
                                                <h4 class="ca-main one">{{number_format($view_count)}}</h4>
                                                <h3 class="ca-sub one">文章访问数</h3>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('dashboard/article')}}">
                                            <i class="fa fa-book" aria-hidden="true"></i>
                                            <div class="ca-content">
                                            <h4 class="ca-main two">{{number_format($article_count)}}</h4>
                                                <h3 class="ca-sub two">文章数</h3>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('dashboard/comment')}}">
                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                            <div class="ca-content">
                                                <h4 class="ca-main three">{{number_format($comment_count)}}</h4>
                                                <h3 class="ca-sub three">评论数</h3>
                                            </div>
                                        </a>
                                    </li>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row row-lg">
                            <div class="col-sm-10">
                                <div class="panel-heading">
                                    <h3 class="panel-title">网站访客信息</h3>
                                </div>
                                <div class="text-right" style="margin: 3px 0 5px 0;">
                                    <h5>今日访客量：<span style="color: #fd9426;">{{$today_visitor_count}}</span>次；网站总访客量：<span style="color: red;">{{$all_visitor_count}}</span>次</h5>
                                </div>
                                <div class="example">
                                    <table id="exampleTableEvents" data-toggle="table" data-height="540" data-mobile-responsive="true">
                                        <thead>
                                            <tr>
                                                <th data-field="ip" data-halign="center" data-align="center">IP地址</th>
                                                <th data-field="country" data-halign="center" data-align="center">访客地址</th>
                                                <th data-field="clicks" data-halign="center" data-align="center" data-sortable="true">总访问次数</th>
                                                <th data-field="today_clicks" data-halign="center" data-align="center" data-sortable="true">当天访问次数</th>
                                                <th data-field="created_at" data-halign="center" data-align="center" data-sortable="true">初次访问时间</th>
                                                <th data-field="updated_at" data-halign="center" data-align="center" data-sortable="true">最新访问时间</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script type="text/javascript">
! function(e, t, o) {
    "use strict";
    ! function() {
        o("#exampleTableEvents").bootstrapTable({
            url: "{{url('dashboard/visitor')}}",
            search: !0,
            pagination: !0,
            showRefresh: !0,
            showToggle: !0,
            showColumns: !0,
            iconSize: "outline",
            icons: {
                refresh: "glyphicon-repeat",
                toggle: "glyphicon-list-alt",
                columns: "glyphicon-list"
            }
        });
    }()
}(document, window, jQuery)
</script>
@stop