<!-- nav start -->
<nav class="am-g am-g-fixed blog-fixed blog-nav">
<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only blog-button" data-am-collapse="{target: '#blog-collapse'}" ><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

<div class="am-collapse am-topbar-collapse" id="blog-collapse">
    <p id="back-to-top"><a href="#top"><span></span>返回顶部</a></p>
    <ul class="am-nav am-nav-pills am-topbar-nav nav navbar-nav">
        <li><a>{{ config('blog.name') }}</a></li>
        <li class="{{active_class(if_uri(['/','blog']),'am-active')}}"><a href="{{url('/')}}">首页</a></li>
        @foreach($category[0] as $v)
            <?php $new_name = $v['path'].'/*';?>
            <li class="am-dropdown {{active_class(if_uri_pattern($new_name),'am-active')}}" data-am-dropdown>
                <a class="am-dropdown-toggle" href="javascript:;" data-am-dropdown-toggle>
                    {{$v['name']}}<span class="am-icon-caret-down"></span>
                </a>
                @if(isset($category[$v['id']]))
                    <ul class="am-dropdown-content">
                        @foreach($category[$v['id']] as $vv)
                            <li class="{{active_class(if_uri($v['path'].'/'.$vv['path']),'am-active')}}"><a href="{{url($v['path'].'/'.$vv['path'])}}">{{$vv['name']}}</a></li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
        <li class="{{active_class(if_uri('contact'),'am-active')}}"><a href="{{url('contact')}}">联系我</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
            <li><a href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
        @else
            <img class="avatar-min img-circle" src="{{ asset(avatar_image(Auth::user()->avatar,60)) }}">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{url('/user')}}">{{ lang('Personal Center') }}</a></li>
                    <li><a href="{{ url('/setting') }}"><i class="ion-gear-b"></i>{{ lang('Settings') }}</a></li>
                    <li>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="color: #000;">注销</a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
    <form class="am-topbar-form am-topbar-right am-form-inline" action="{{url('/search')}}" method="GET" role="search">
        {{-- <div class="am-form-group">
            <input type="text" class="am-form-field am-input-sm" placeholder="搜索">
        </div> --}}
        <div class="am-u-lg-10">
            <div class="am-input-group">
              <input type="text" class="am-form-field" name="key" value="{{{$key or ''}}}" placeholder="搜索" required="">
              <span class="am-input-group-btn">
                <button class="am-btn am-btn-default" type="sublime"><span class="am-icon-search"></span></button>
              </span>
            </div>
        </div>
    </form>
</div>
</nav>
<hr>