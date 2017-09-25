@extends('admin.layouts.base')

@section('title','控制面板')
@section('css')
<link href="{{asset('css/style_grid.css')}}" rel="stylesheet" type="text/css" media="all" />
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
                                                <h3 class="ca-sub one">访问数</h3>
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
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
{{-- 暂时不做图标统计 --}}
<!-- Sparkline -->
{{-- <script src="{{asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script> --}}
<!-- Peity -->
{{-- <script src="{{asset('js/plugins/peity/jquery.peity.min.js')}}"></script> --}}
@stop