<div class="container-fluid">
    <div class="user jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 text-center">
                    <img class="avatar img-circle" src="{{ asset(avatar_image($user->avatar,200)) }}">
                </div>
                <div class="col-sm-5 content">
                    <div class="header">
                        {{ $user->nickname or $user->name }}
                    </div>
                    <div class="description">
                        {{ $user->description or lang('Nothing') }}
                    </div>
                    @if(Auth::check())
                        <div class="actions">
                            @if(Auth::id() != $user->id)
                                <a  href="javascript:void(0)"
                                    class="btn btn-{{ Auth::user()->isFollowing($user->id) ? 'warning' : 'danger' }} btn-sm"
                                    onclick="event.preventDefault();
                                             document.getElementById('follow-form').submit();">
                                    {{ Auth::user()->isFollowing($user->id) ? lang('Following') : lang('Follow') }}
                                </a>

                                <form id="follow-form" action="{{ url('user/follow', [$user->id]) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            @else
                                <a href="{{ url('user/profile') }}" class="btn btn-info btn-sm">{{ lang('Edit Profile') }}</a>
                            @endif
                        </div>
                    @endif
                    <div class="footer">
                        <p data-am-popover="{content: '{{ $user->name }}的 经历' ,trigger: 'hover focus'}">
                            @if($user->address)
                                来自于<span>{{$user->address}}</span>
                            @endif
                            @if($user->company)
                                任职于<span>{{$user->company}}</span>
                            @endif
                            @if($user->occupation)
                                专职于<span>{{$user->occupation}}</span>
                            @endif
                        </p>
                        @if($user->qq)
                            <p><i class="am-icon-qq"></i>：<span data-am-popover="{content: '{{ $user->name }}的 QQ' ,trigger: 'hover focus'}">{{$user->qq}}</span></p>
                        @endif
                        @if($user->github_name)
                        <a class="btn btn-sm btn-primary" target="_blank" href="https://github.com/{{ $user->github_name }}" data-am-popover="{content: '{{ $user->name }}的 Github' ,trigger: 'hover focus'}">
                            <i class="am-icon-github am-icon-sm"></i>
                        </a>
                        @endif
                        @if($user->website)
                        <a class="btn btn-sm btn-primary" target="_blank" href="{{ $user->website }}" data-am-popover="{content: '{{ $user->name }}的 个人网站' ,trigger: 'hover focus'}">
                            <i class="am-icon-globe am-icon-sm"></i>
                        </a>
                        @endif
                        @if($user->weibo_link)
                        <a class="btn btn-sm btn-primary" target="_blank" href="{{ $user->weibo_link }}" data-am-popover="{content: '{{ $user->name }}的 微博{{'--'.$user->weibo_name}}' ,trigger: 'hover focus'}">
                            <i class="am-icon-weibo am-icon-sm"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-sm-5 user-follow">
                    <div class="row">
                        <div class="col-xs-4">
                            <a href="{{ url("user/{$user->name}/following") }}" class="counter">{{ $user->followings()->count() }}</a>
                            <a href="{{ url("user/{$user->name}/following") }}" class="text">{{ lang('Following Num') }}</a>
                        </div>
                        <div class="col-xs-4">
                            <a href="{{ url("user/{$user->name}/comments") }}" class="counter">{{ $user->comments->count() }}</a>
                            <a href="{{ url("user/{$user->name}/comments") }}" class="text">{{ lang('Comment Num') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>