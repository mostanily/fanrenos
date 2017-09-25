@extends('admin.layouts.base')

@section('title','控制面板')

@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">系统配置</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-10">
                                <div class="tabs-container">

                                    <div class="tabs-left">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#tab-8"><i class="fa fa-jsfiddle"></i> 系统</a>
                                            </li>
                                            <li class=""><a data-toggle="tab" href="#tab-9"><i class="fa fa-file-code-o"></i> PHP</a>
                                            </li>
                                            <li class=""><a data-toggle="tab" href="#tab-10"><i class="fa fa-database"></i> 数据库</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content ">
                                            <div id="tab-8" class="tab-pane active">
                                                <div class="panel-body">
                                                    <h2>系统</h2>
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th data-sortable="false" class="hidden-sm">设置</th>
                                                                <th data-sortable="false" class="hidden-sm">值</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="hidden-sm">网站服务器</td>
                                                                <td class="hidden-sm">{{$server}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hidden-sm">域名</td>
                                                                <td class="hidden-sm">{{$http_host}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hidden-sm">IP</td>
                                                                <td class="hidden-sm">{{$remote_host}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hidden-sm">User Agent</td>
                                                                <td class="hidden-sm">{{$user_agent}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div id="tab-9" class="tab-pane">
                                                <div class="panel-body">
                                                    <h2>PHP</h2>
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th data-sortable="false" class="hidden-sm">设置</th>
                                                                <th data-sortable="false" class="hidden-sm">值</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="hidden-sm">版本</td>
                                                                <td class="hidden-sm">{{$php}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hidden-sm">Handler</td>
                                                                <td class="hidden-sm">{{$sapi_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hidden-sm">扩展</td>
                                                                <td class="hidden-sm">{{$extensions}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div id="tab-10" class="tab-pane">
                                                <div class="panel-body">
                                                    <h2>数据库</h2>
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th data-sortable="false" class="hidden-sm">设置</th>
                                                                <th data-sortable="false" class="hidden-sm">值</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="hidden-sm">驱动</td>
                                                                <td class="hidden-sm">{{$db_connection}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hidden-sm">数据库</td>
                                                                <td class="hidden-sm">{{$db_database}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hidden-sm">版本</td>
                                                                <td class="hidden-sm">{{$db_version}}</td>
                                                            </tr>
                                                        </tbody>
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
            </div>
        </div>
    </div>
@stop