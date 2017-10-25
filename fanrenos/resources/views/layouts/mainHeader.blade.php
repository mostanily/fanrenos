<!-- nav start -->
<header class="am-topbar am-topbar-fixed-top" style="padding: 0 10%;">
    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only blog-button" data-am-collapse="{target: '#blog-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
    <div class="am-collapse am-topbar-collapse" id="blog-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav nav navbar-nav">
            <li><a href="{{url('/')}}" class="am-text-ir" title="凡人OS|凡喵"><img src="{{asset('images/logo.png')}}"></a></li>
            <li class="{{active_class(if_uri(['/','blog']),'am-active')}}"><a href="{{url('/')}}">首页</a></li>
            @if(isset($category[0]))
                @foreach($category[0] as $v)
                <li class="am-dropdown" data-am-dropdown>
                    <a class="am-dropdown-toggle" href="javascript:;" data-am-dropdown-toggle>
                        {{$v['name']}}<span class="am-icon-caret-down"></span>
                    </a> @if(isset($category[$v['id']]))
                    <ul class="am-dropdown-content">
                        @foreach($category[$v['id']] as $vv)
                        <li class="{{active_class(if_uri($v['path'].'/'.$vv['path']),'am-active')}}"><a href="{{url($v['path'].'/'.$vv['path'])}}">{{$vv['name']}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            @endif
            <li class="{{active_class(if_uri('contact'),'am-active')}}"><a href="{{url('contact')}}">联系我</a></li>
        </ul>
        <form class="am-topbar-form am-topbar-left am-form-inline" action="{{url('/search')}}" method="GET" role="search">
            <div class="am-u-lg-10">
                <div class="am-input-group">
                    <input type="text" class="am-form-field" name="key" value="{{{$key or ''}}}" placeholder="搜索" required="">
                    <span class="am-input-group-btn">
                <button class="am-btn am-btn-default" type="sublime"><span class="am-icon-search"></span></button>
                    </span>
                </div>
            </div>
        </form>
        <div class="am-topbar-right">
            @if (Auth::guest())
            <div class="am-topbar-right">
                <button class="am-btn am-btn-primary am-topbar-btn am-btn-sm" onclick="toJump('{{ url("/login") }}','_blank')">登陆</button>
                <button class="am-btn am-btn-primary am-topbar-btn am-btn-sm" onclick="toJump('{{ url("/register") }}','_blank')">注册</button>
            </div>
            @else
            <div class="am-dropdown user-info" data-am-dropdown="{boundary:'.am-topbar'}">
                <img class="avatar-min img-circle" src="{{ asset(avatar_image(Auth::user()->avatar,60)) }}" style="margin-right: 3px;">
                <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>{{ Auth::user()->name }}<span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="{{url('/user')}}">{{ lang('Personal Center') }}</a></li>
                    <li><a href="{{ url('/setting') }}"><i class="ion-gear-b"></i>{{ lang('Settings') }}</a></li>
                    <li>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="color: #000;">注销</a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</header>
<div class="side">
    <ul style="padding-left: 0px;">
        <li><a href="javascript:;" id="demo-full-page"><div class="sidebox"><img src="{{asset('imgs/full_screen.png')}}">全屏显示</div></a></li>
        <li style="border:none;"><a href="javascript:goBottom();" class="sidetop"><img src="{{asset('imgs/to_bottom.png')}}"></a></li>
        <li style="border:none;"><a href="javascript:goTop();" class="sidetop"><img src="{{asset('imgs/to_top.png')}}"></a></li>
    </ul>
</div>