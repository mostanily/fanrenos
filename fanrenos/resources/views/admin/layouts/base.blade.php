<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | v1.0</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" type="image/ico" href="{{asset('favicon.ico')}}">
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet" type="text/css" media="all" />
    <!-- Bootstrap 3.3.6 -->
    {{-- <link rel="stylesheet" href="{{asset('/bootstrap/css/bootstrap.min.css')}}"> --}}
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/libs/font-awesome/4.5.0/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('/libs/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="{{asset('/dist/css/AdminLTE.min.css')}}"> --}}
    <link href="https://cdn.bootcss.com/admin-lte/2.4.2/css/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">

    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{asset('/dist/css/skins/skin-blue.min.css')}}">

    <!--bootstrap-select-->
    <link href="https://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/css/bootstrap-select.min.css" rel="stylesheet">
    {{-- <link href="{{asset('plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet"> --}}


    <!-- iCheck -->
    {{-- <link href="{{asset('plugins/iCheck/flat/grey.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/iCheck/flat/blue.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/iCheck/flat/yellow.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/iCheck/flat/purple.css')}}" rel="stylesheet"> --}}
    <link href="{{asset('plugins/iCheck/flat/red.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/iCheck/flat/green.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/iCheck/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.min.css')}}" rel="stylesheet">

    {{-- <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-tags-input/jquery.tagsinput.css')}}" /> --}}
    <link href="https://cdn.bootcss.com/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    {{--dataTabels--}}
    {{-- <link href="{{asset('/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet"> --}}
    <link href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">

    {{--loding--}}
    <link href="{{asset('/dist/css/load/load.css')}}" rel="stylesheet">

    <link href="{{asset('css/upload-img.css')}}" rel="stylesheet">
    @yield('css')
</head>
<!--
BODY TAG OPTIONS:
=================
-->
<body class="hold-transition skin-blue sidebar-mini">
<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="object" id="object_four"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_one"></div>
        </div>
    </div>
</div>
<div class="wrapper">

    <!-- Main Header -->
    @include('admin.layouts.mainHeader')
            <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layouts.mainSidebar')
            <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h6></h6>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="modal fade modal-danger" id="MyalertModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close close-myalert" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">警告</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left close-myalert" data-dismiss="modal">关闭</button>
                            <button type="button" url="" data="" class="btn btn-default del_sure" style="display: none;">确定</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="modal-dialog" tabIndex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                            <h4 class="modal-title">提示</h4>
                        </div>
                        <div class="modal-body">
                            <p class="lead dialog-content">
                                <i class="fa fa-question-circle fa-lg"></i>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 浏览图片 --}}
            <div class="modal fade" id="modal-image-view">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                            <h4 class="modal-title">预览图片</h4>
                        </div>
                        <div class="modal-body">
                            <img id="preview-image" src="" class="img-responsive">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                关闭
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-heading">
                <ul class="breadcrumb"></ul>
            </div>
            @yield('content')
                    <!-- Your Page Content Here -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
{{-- <script src="{{asset('/plugins/jQuery/jquery-2.2.3.min.js')}}"></script> --}}
<script src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>

<!--bootstrap-select-->
<script src="https://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/js/bootstrap-select.min.js"></script>
{{-- <script src="{{asset('/plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script> --}}

{{-- <script src="{{asset('js/jquery.isotope.js')}}"></script> --}}
<script src="https://cdn.bootcss.com/jquery.isotope/3.0.4/isotope.pkgd.min.js"></script>

<!--tags input-->
{{-- <script src="{{asset('plugins/jquery-tags-input/jquery.tagsinput.js')}}"></script> --}}
<script src="https://cdn.bootcss.com/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>
<script src="{{asset('js/tagsinput-init.js')}}"></script>

<!-- Bootstrap 3.3.6 -->
{{-- <script src="{{asset('/bootstrap/js/bootstrap.min.js')}}"></script> --}}
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('/dist/js/app.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>

<!-- bootstrap-table -->
<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.js"></script>
<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/locale/bootstrap-table-zh-CN.min.js"></script>

<!-- dataTables -->
<script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
{{-- <script src="{{asset('/plugins/datatables/dataTables.bootstrap.js')}}"></script> --}}
<script src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="{{asset('/plugins/tokenfield/dist/bootstrap-tokenfield.min.js')}}"></script>
<script src="{{asset('/dist/js/common.js')}}"></script>
<script src="{{asset('js/content.min.js')}}"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<!--第三方插件样式-->
<script type="text/javascript">
    $(function(){
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }
          $(this).data("clicks", !clicks);
        });
        //Flat red,green color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-red',
          radioClass: 'iradio_flat-red'
        });
        $('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });
    });
</script>

<script type="text/javascript">

    function back_btn(){
        window.history.back(-1);
    }
    function back_index() {
        window.location.href = "{{url('dashboard')}}";
    }
    function changeAddress(str){
        var ca=str.split("/");
        $("#city-picker3").attr("value",str);
        $(".select-item:eq(0)").html(ca[0]);
        $(".select-item:eq(1)").html(ca[1]);
        $(".select-item:eq(2)").html(ca[2]);
    }
    function myalert(con,sure,url,data){
        if(sure=='make-sure'){
            $('.del_sure').attr('url',url);
            $('.del_sure').attr('data',data);
            $('.del_sure').show();
        }else{
            $('.del_sure').hide();
        }
        $('#MyalertModal>.modal-dialog>.modal-content>.modal-body').children('p').html(con);
        $('#MyalertModal').modal('show');
    }
    function mydialog(con){
        $('.dialog-content').text(con);
        $('#modal-dialog').modal();
    }
    function toJump(url,target){
        if(target=='_blank'){
            window.open(url);
        }else{
            window.location.href = url;
        }
    }

    function recoveryDel(handle,id){
        var u = "{{url('dashboard/recovery')}}"+'/'+handle+'/'+id;
        toJump(u);
    }

    function close_myalert(){
        $('#MyalertModal>.modal-dialog>.modal-content>.modal-body').children('p').html("");
        $('#MyalertModal').modal('hide');
    }
    
    //首页列表复选框，获取选择项对应的ID
    function getSelect(){
        var p = $(".all_select:checked");
        var b = new Array();
        for (var i = 0; i < p.length; i++) {
            b.push(p.eq(i).val());
        }
        if(b.length==0){
            return false;
        }else{
            var s = b.toString();
            return s;
        }
    }

    //全选
    $('#all_select').click(function(event) {
        var is_checked = $(this).hasClass('is-checked');
        if(is_checked){
            $('.all_select').prop('checked',false);
            $(this).removeClass('is-checked');
        }else{
            $('.all_select').prop('checked',true);
            $(this).addClass('is-checked');
        }
    });
    //批量删除(只针对存在软删除的model)
    function batchDel(model){
        var id = getSelect();
        if(!id){
            myalert('没有进行任何选择！');
        }else{
            var u = "{{url('dashboard/batch_delete')}}"+'/'+model;
            var data = 'pid='+id;
            myalert('确定需要批量删除么？','make-sure',u,data);
        }
    }

    function chcheClear(){
        $.get("{{url('dashboard/clear/cache')}}",function(msg){
            if(msg.status=='success'){
                mydialog('缓存清除成功！');
            }
        });
    }

    $('.close-myalert').click(function(){
        $('#MyalertModal>.modal-dialog>.modal-content>.modal-body').children('p').html("");
        $('#MyalertModal').modal('hide');
    });

    // 预览图片
    function preview_image(path) {
        $("#preview-image").prop("src", '');
        $("#preview-image").prop("src", path);
        $("#modal-image-view").modal("show");
    }

    $('.del_sure').click(function(){
        var url = $(this).attr('url');
        var data = $(this).attr('data');
        $.ajax({
            url:url,
            type:"POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data:data,
            success:function(msg){
                if(msg.status=='success'){
                    window.location.reload();
                }else if(msg.code==403){
                    myalert(msg.msg);
                }else if(msg.status=='no change'){
                    $('.coupon_select').val(msg.old_msg);
                }else if(msg.status=='failed-child'){
                    myalert(msg.msg+'<br>确定需要清除该对象的所有关联，并删除该对象？点此确定<a href="javascript:;" data-id="'+msg.id+'" class="btn btn-info clear_all_link">删除</a>将会彻底删除？');
                }else{
                    myalert('网络出错，请重试！');
                }
            }
        });
    });

    $(function(){
        if($('.treeview-menu>li').hasClass('active')){
            $('.treeview-menu>li.active').parent('ul').parent('.treeview').addClass('active');
        }
        var is_edit = $('#is_edit_route').val();
        var is_recycle = $('#is_recycle_route').val();
        var li_str = $('.treeview.active>a>span').text().trim();
        var li_str_c = $('.treeview.active>.treeview-menu>li.active>a').text().trim();
        var prev_url = $('.treeview.active>.treeview-menu>li.active>a').attr('href');
        var li_html = '';

        if(li_str==''){
            li_html = '<li><a href="{{url('dashboard')}}" style="color:#333;"><i class="fa fa-home"></i>首页</a></li>';
        }else{
            if(is_edit=='true' || is_edit==1){
                li_html = '<li><a href="{{url('dashboard')}}" style="color:#333;"><i class="fa fa-home"></i>首页</a></li><li>'+ li_str +'</li><li><a href="'+prev_url+'" style="color:#333;">'+li_str_c+'</a></li><li class="active">编辑</li>';
            }else if(is_recycle=='true' || is_recycle==1){
                li_html = '<li><a href="{{url('dashboard')}}" style="color:#333;"><i class="fa fa-home"></i>首页</a></li><li>'+ li_str +'</li><li><a href="'+prev_url+'" style="color:#333;">'+li_str_c+'</a></li><li class="active">回收站</li>';
            }else{
                li_html = '<li><a href="{{url('dashboard')}}" style="color:#333;"><i class="fa fa-home"></i>首页</a></li><li>'+ li_str +'</li><li class="active">'+li_str_c+'</li>';
            }
        }

        $('.breadcrumb').append(li_html);
        /*end*/

        //鼠标双击后变为可编辑状态
        $(document).on('dblclick','.check_edit_normal',function(){
            var con = $(this).text().trim();
            if(!$(this).parent().hasClass('row')){
                var input = '<input type="text" style="width:99%;" old-info="'+con+'" name="" class="form-control small" value="'+con+'" />';
                $(this).html("");
                $(this).append(input);
                con = $(this).children('input').focus();
            }

        });

        //上传图片设置(基本通用)
        $(document).on("click",".add_new_img",function(){
            var insert='<input type="file" name="upload_images[]" class="form_upload_file">';
            var thisparent=$(this).parents(".comment_form");
            var index=thisparent.find(".img_showbox").length;
            if(thisparent.find(".form_upload_file:eq("+index+")").length==0){
                thisparent.append(insert);
            }
            thisparent.find(".form_upload_file:eq("+index+")").trigger("click");
        });

        $(document).on("change",".form_upload_file",function(){
            var preload_position=$(this).parents(".comment_form").find(".upload_img_showbox");
            var filetype=this.files[0].type.split('/');
            if(this.files[0].size > 1024*1024*5){
                $(this).remove();
                alert("单张图片不能大于5M");
            }else if(filetype[0]=="image"){
                var reader = new FileReader();
                reader.readAsDataURL(this.files[0]);
                reader.onload = function(e){
                    var insert='<div class="img_showbox"><img src="'+this.result+'"><span class="del_upload_file">删除</span></div>';
                    preload_position.append(insert);
                }
            }else{
                $(this).remove();
                    alert("请上传正确的图片");
            }
        });

        $(document).on("click",".del_upload_file",function(){
            var i=$(this).parents(".img_showbox").index();
            $(this).parents("form").find(".form_upload_file").eq(i).remove();

            if($(this).parents(".img_showbox").length<6){
                $(this).parents(".upload_img_showbox").find(".add_new_img").parent('p').show();
            }
            $(this).parent().remove();
        });
        //end
    });
</script>
@yield('js')
        <!-- Main Footer -->
@include('admin.layouts.mainFooter')
</body>
</html>
