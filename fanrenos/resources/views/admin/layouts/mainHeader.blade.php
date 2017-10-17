  <header class="main-header">

    <!-- Logo -->
    <a href="{{url('dashboard')}}" class="logo" style="position: fixed;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>管理</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>后台管理</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="" >
            <a href="{{url('/')}}" title="返回主页" target="_blank"><i class="fa fa-desktop"></i></a>
          </li>
          <li class="" >
            <a href="javascript:;" onclick="chcheClear()" title="清除缓存"><i class="fa fa-refresh"></i></a>
          </li>
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">{{auth('admin')->user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{asset('/123.png')}}" class="img-circle" alt="User Image">
                <p>
                  {{auth('admin')->user()->name}} - 系统管理员
                  <small>最后登录:{{date('Y-m-d H:i',strtotime(auth('admin')->user()->updated_at))}}</small>
                </p>
              </li>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                
                <div class="pull-right">
                  <a href="{{url('/dashboard/logout')}}" class="btn btn-default btn-flat">登出</a>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </header>