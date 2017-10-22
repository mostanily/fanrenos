<aside class="main-sidebar" style="position: fixed;">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">栏目导航</li>
            <!-- Optionally, you can add icons to the links -->
            
            <?php $comData=Request::get('comData_menu'); ?>
            <input type="hidden" id="is_edit_route" value="{{$comData[1]}}" >
            <input type="hidden" id="is_recycle_route" value="{{$comData[2]}}" >
            @foreach($comData[0] as $v)
                @if(!empty($v['route']))
                    <li class="@if($v['isActive']) active @endif">
                        <a href="{{url($v['route_alias'])}}"><i class="fa {{ $v['icon'] }}"></i> <span>{{$v['TitleNav']}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                    </li>
                @else
                    <li class="treeview  @if($v['isActive']) active @endif">
                        <a href="#"><i class="fa {{ $v['icon'] }}"></i> <span>{{$v['TitleNav']}}</span> <i
                                    class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @foreach($v['subTitleNav'] as $vv)
                                <li class=" @if($vv['isActive']) active @endif" ><a href="{{url($vv['route_alias'])}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i>{{$vv['name']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                
            @endforeach
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>