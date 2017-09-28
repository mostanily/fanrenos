@extends('layouts.base')

@section('content')
<div class="container profile">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <div class="am-form-group">
                <img class="avatar" src="{{ asset(avatar_image($user->avatar,200)) }}" width="140"> 
                <a style="margin-top: 10px;font-size: 14px;" class="am-btn am-btn-success am-round col-md-10" href="{{url('/user/profile/avatar')}}">修改头像</a>
            </div>
        </div>
        <div class="col-md-7">
            <form action="{{ url('user/profile', ['id' => $user->id]) }}" method="POST" class="form-horizontal">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <fieldset>
                    <div class="form-group">
                        <label for="Name" class="col-md-3 control-label">{{ lang('Username') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Name" value="{{ $user->name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Email" class="col-md-3 control-label">{{ lang('Email') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Email" value="{{ $user->email }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Nickname" class="col-md-3 control-label">{{ lang('Nickname') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Nickname" name="nickname" value="{{ $user->nickname }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Website" class="col-md-3 control-label">{{ lang('Website') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Website" name="website" value="{{ $user->website }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Weibo" class="col-md-3 control-label">{{ lang('Weibo Name') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Weibo" name="weibo_name" value="{{ $user->weibo_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Weibo-home" class="col-md-3 control-label">{{ lang('Weibo Home') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Weibo-home" name="weibo_link" value="{{ $user->weibo_link }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="QQ" class="col-md-3 control-label">{{ lang('QQ') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="QQ" name="qq" value="{{ $user->qq }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="GitHub" class="col-md-3 control-label">GitHub</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="GitHub" name="github_name" value="{{ $user->github_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Company" class="col-md-3 control-label">{{lang('Company')}}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Company" name="company" value="{{ $user->company }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Occupation" class="col-md-3 control-label">{{lang('Occupation')}}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Occupation" name="occupation" value="{{ $user->occupation }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Address" class="col-md-3 control-label">{{lang('Address')}}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Address" name="address" value="{{ $user->address }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Description" class="col-md-3 control-label">{{ lang('Description') }}</label>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="3" name="description" id="Description">{{ $user->description }}</textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-action row">
                        <div class="col-md-offset-3 col-md-9 col-xs-12">
                            <button class="btn btn-success btn-block" type="submit">{{ lang('Update Profile') }}</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection
