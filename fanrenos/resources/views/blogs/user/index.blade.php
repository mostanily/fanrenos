@extends('layouts.base')
@section('css')

@stop
@section('content')
    @include('blogs.user.particals.info')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('Recent Comments') }}</div>

                    @include('blogs.user.particals.comments')

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop