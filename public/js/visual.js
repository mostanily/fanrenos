var add_store={
  'add_pic':'<a href="javascript:void(0)" class="visual_element visual_pic drag_element" data-link="" style="height:auto"><img src="'+sample_image+'" ondragstart="return!1" title="描述文字"> <span class="del">删除</span> <span class="size"></span></a>',

  'add_video':'<div class="visual_element visual_video drag_element" data-link="" style="height:auto"><video src="'+sample_video+'" controls>您的浏览器不支持 video 标签。</video><span class="del">删除</span> <span class="size"></span></div>',

  'add_text':'<a href="javascript:void(0)" class="visual_element visual_text drag_element" style="width:100%;height:auto" data-link=""><p>双击编辑文字</p><span class="del">删除</span> <span class="size"></span></a>',

  'add_time':'<div class="visual_element drag_element visual_time" data-link="" data-time="" data-start="false" style="height:auto"><div class="time_box" data-time=""><span class="time_day">00</span><b>天</b><span class="time_h">00</span><b>时</b><span class="time_m">00</span><b>分</b><span class="time_s">00</span><b>秒</b></div><span class="del">删除</span> <span class="size"></span></div>',

  'add_banner':'<div class="visual_element visual_banner drag_element" data-link="" style="height:auto"><div class="swiper-container banner_container scroll_touch" data-space-between="10"><div class="swiper-wrapper"><div class="swiper-slide"><a href="javascript:void(0)" data-link=""><img src="'+sample_image+'" title="info"></a></div><div class="swiper-slide"><a href="javascript:void(0)" data-link=""><img src="'+sample_image+'" title="info"></a></div><div class="swiper-slide"><a href="javascript:void(0)" data-link=""><img src="'+sample_image+'" title="info"></a></div></div><div class="swiper-pagination"></div></div><span class="del">删除</span> <span class="size"></span></div>'
}
$(".save_visual").click(function(){
  var page_id=$(this).attr("con-id");
  var page_title=$("#page_title").val();
  var page_edit=$(".visual_edit_box").html();
  var con=$(".visual_edit_box").clone();
  con.find(".visual_element").removeClass("drag_element");
  con.find(".del").remove();
  con.find(".size").remove();
  var elements=con.find(".visual_element");
  for(var i=0;i<elements.length;i++){
    var link=elements.eq(i).attr("data-link");
    if(link){
      //有链接
      if(elements.eq(i).is("a")){
        elements.eq(i).attr("href",link);
      }
      else{
        elements.eq(i).attr("onclick","window.location.href='"+link+"'");
      }
    }
    else{
      var images=elements.eq(i).find("a");
      for(var j=0;j<images.length;j++){
        var a_link=images.eq(i).attr("data-link");
        if(a_link){
          images.eq(i).attr("href",a_link);
        }
      }
    }
  }
  var page_context=con.html();
  var url=$(this).attr("data-save");
  $.ajax({
    url:url,
    type:'POST',
    dataType:'json',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data:{'_method':'PUT','page_id':page_id,'page_title':page_title,'page_edit':page_edit,'page_context':page_context},
    success:function(msg){
      console.log(msg);
      if(msg=="success"){
        window.location.reload();
      }
      if(msg=="store"){
        window.history.back();
      }
    },
    error:function(){
      alert('修改失败');
    }
  });
});
$(document).on("click",".add_button",function(){
  var id=$(this).attr("id");
  $(".visual_edit_box").append(add_store[id]);
});
//------------------删除板块-----------------------
$(document).on("click",".del",function(){
  if(confirm("确定删除？")){
    $(this).parents(".visual_element").remove();
  }
});
//----------------板块顺序拖拽----------------------
var drag_box_control={'state':false,'position':""};
$(document).on("mousedown",".drag_element",function(e){
    $(".move_dragbox").html("");
    drag_box_control.state=true;
    var element=$(this);
    setTimeout(function(){
      drag_box_control.position=element.index();
      if(drag_box_control.state){
        $(".move_dragbox").append(element).show().css({'left':e.clientX,'top':e.clientY});
      }
    },2000);
});
$(document).on("mousemove",function(e){
  if(drag_box_control.state){
    var test=e.clientX+" "+e.clientY;
    $(".move_dragbox").css({'left':e.clientX,'top':e.clientY});
  }
});
$(document).on("mouseup",function(e){
  drag_box_control.state=false;
  $(".move_dragbox").hide();
  if($(".move_dragbox").html()!=""){
    var x=e.clientX;
    var y=e.clientY;
    var edit_box=$(".visual_edit_box");
    var out_left=edit_box.offset().left;
    //开始判断
    if(x-out_left<0 || x>out_left+edit_box.width()){
        box_to_visual();
    }
    else{
      var ele=$(".visual_edit_box .drag_element.hover");
      if(ele.length<1){
        box_to_visual();
      }
      else{
        var top=ele.offset().top;
        if(y>top && y<top+ele.height()/2){
          ele.before($(".move_dragbox").children());
        }
        else{
          ele.after($(".move_dragbox").children());
        }
      }
    }
  }
});
$(document).on("mouseover",".visual_edit_box .drag_element",function(){
  $(".drag_element").removeClass("hover");
  $(this).addClass("hover");
});
$(document).on("mouseleave",".visual_edit_box .drag_element",function(){
  $(".drag_element").removeClass("hover");
});
function box_to_visual(){
    var len=$(".visual_edit_box .drag_element").length;
    var last=$(".drag_element").eq(drag_box_control.position);
    if(len-1>=drag_box_control.position){
      last.before($(".move_dragbox").children());
    }
    else{
      $(".visual_edit_box").append($(".move_dragbox").children());
    }
}
//----------------拖动菜单位置-----------------
var touch_menu={'state':false,w:"",h:""};
$(document).on("mousedown",".menu",function(e){
  if($(e.target).hasClass("menu")){
    touch_menu.state=true;
    touch_menu.w=e.clientX-e.target.offsetLeft;
    touch_menu.h=e.clientY-e.target.offsetTop;
    $(this).addClass("move");
  }
});
$(document).on("mousemove",".menu",function(e){
  if(touch_menu.state){
    $(this).css({'left':e.clientX-touch_menu.w,'top':e.clientY-touch_menu.h,'margin-top':'0px'});
  }
});
$(document).on("mouseup",function(){
  if(touch_menu.state){
    $(".menu").removeClass("move");
    touch_menu.state=false;
  }
});
//------------------删除banner------------------
$(document).on("click",".del_banner",function(){
  $(this).parent().remove();
});
//------------------增加banner------------------
$(document).on("click","#add_new_banner",function(){
  var str='<p class="part part3"><label>图片地址：</label><input type="text" value=""><br><label>跳转链接：</label><input type="text" value=""><br><label>文字描述：</label><input type="text" value=""><span class="del_banner">删除</span></p>';
  $(this).before(str);
});
//-------------------------------确定按钮-----------------------------------
$(document).on("click","#menu_sure",function(){
  //-----------------公共参数-------------------
  var wid=$("#menu_width").val();
  var height=$("#menu_height").val();
  var padding=$("#menu_padding").val();
  var link=$("#menu_link").val();
  var element=$(".drag_element.active");
  //--------------------------------------------
  element.css({'width':wid,'height':height,'padding':padding});
  element.attr("data-link",link);
  //----------------图片/视频参数---------------
  if(element.hasClass("visual_pic")){
    var url=$("#menu_url").val();
    var des=$("#menu_des").val();
    var imgele=element.find("img").eq(0);
    imgele.attr({"src":url,'title':des});
  }
  else if(element.hasClass("visual_video")){
    var url=$("#menu_url").val();
    var video=element.find("video").eq(0);
    video.attr({"src":url});
  }
  //-----------------文字参数-------------------
  else if(element.hasClass("visual_text")){
    var paras=$(".part2");
    for(var i=0;i<paras.length;i++){
      var input=paras.eq(i).find("input[type=text]");
      var attr=input.attr("id");
      var val=input.val();
      element.css(attr,val);
    }
    var align=$("input[name=text-align]:checked").val();
    element.css("text-align",align);
  }
  //-----------------banner参数-------------------
  else if(element.hasClass("visual_banner")){
    $(".swiper-wrapper").html("");
    var images=$(".menu .part3");
    for(var i=0;i<images.length;i++){
      var inputs=images.eq(i).find("input");
      var url=inputs.eq(0).val();
      var link=inputs.eq(1).val();
      var title=inputs.eq(2).val();
      var str='<div class="swiper-slide"><a href="javascript:void(0)" data-link="'+link+'"><img src="'+url+'" title="'+title+'"></a></div>';
      $(".swiper-wrapper").append(str);
    }
  }
  //----------------倒计时参数--------------------
  else if(element.hasClass("visual_time")){
      var set_time=$("#time_set").val();
      if(set_time){
        element.attr("data-time",set_time);
        if(element.attr("data-start")=="false"){
          init_time(element);
        }
      }
  }
});
//----------------------取消右键默认菜单----------------------
document.oncontextmenu = function(event){
  event.preventDefault();
};
//--------------------------文字编辑--------------------------
$(document).on("dblclick",".drag_element.visual_text",function(){
  $(".drag_element").removeClass("active");
  $(this).addClass("active").attr("contenteditable",true);
  $(this).forcus();
});
$(document).on("blur",".drag_element.visual_text",function(){
  $(this).attr("contenteditable",false);
  window.getSelection().removeAllRanges();
  document.selection.empty();
});
//---------------------------------调出菜单----------------------------------
$(document).on("mousedown",".drag_element",function(e){
  if(e.button ==2){
    $(this).addClass("active");
    //-----------动态修改menu显示位置-----------
    $(".menu_content").show();
    var h=$(window).height();
    var pos='top';
    var y=e.clientY;
    var menu=$(".menu_content .menu");
    if(e.clientY>0.5*h){
      menu.css("margin-top","-"+menu.height()+"px");
    }
    else{
      menu.css("margin-top","0px");
    }
    //---------------公共参数显示---------------
    var total_wid=$(".visual_edit_box").width();
    $("#menu_width").val(parseFloat($(this).width()/total_wid*100).toFixed(1)+"%");
    $("#menu_height").val($(this).css("height"));
    $("#menu_padding").val($(this).css("padding"));
    var link=$(this).attr("data-link");
    $("#menu_link").val(link);
    //----------------专属参数显示--------------
    $(".part").hide();
    $("#menu_des").removeAttr("disabled");
    $("#menu_link").removeAttr("disabled");
    $(".banner_need_hide").show();
    $("#add_new_banner").hide();
    if($(this).hasClass("visual_pic")){
      //图片
      var src=$(this).find("img").eq(0).attr("src");
      $("#menu_url").val(src?src:'');
      var title=$(this).find("img").eq(0).attr("title");
      $("#menu_des").val(title?title:'');
      $(".part1").show();
    }
    else if($(this).hasClass("visual_video")){
      //视频
      var src=$(this).find("video").eq(0).attr("src");
      $("#menu_url").val(src?src:'');
      $("#menu_des").val('').attr("disabled","disabled");
      $("#menu_link").val('').attr("disabled","disabled");
      $(".part1").show();
    }
    else if($(this).hasClass("visual_text")){
      //文字
      var paras=$(".part2");
      for(var i=0;i<paras.length;i++){
        var input=paras.eq(i).find("input[type=text]");
        var id=input.attr("id");
        $("#"+id).val($(this).css(id));
      }
      var align=$(this).css("text-align");
      $("#"+align).attr("checked",true);
      $(".part2").show();
    }
    else if($(this).hasClass("visual_banner")){
      //banner
      $(".banner_need_hide").hide();
      $(".part3").remove();
      var banners=$(this).find(".swiper-slide");
      for(var i=0;i<banners.length;i++){
        var image=banners.eq(i).find("img");
        var url=image.attr("src");
        var title=image.attr("title");
        var link=image.parent("a").attr("data-link");
        var str='<p class="part part3"><label>图片地址：</label><input type="text" value="'+url+'"><br><label>跳转链接：</label><input type="text" value="'+link+'"><br><label>文字描述：</label><input type="text" value="'+title+'"><span class="del_banner">删除</span></p>';
        $("#add_new_banner").before(str);
      }
      $("#add_new_banner").show();
    }
    else if($(this).hasClass("visual_time")){
      //倒计时
      var set_time=$(this).attr("data-time");
      $("#time_set").val(set_time);
      $("#menu_link").val($(this).attr("data-link"));
      $(".part4").show();
    }
    //------------------------------------------
    $(".menu_content").show();
    menu.css({'left':e.clientX,'top':e.clientY});
  }
  else if($(this).hasClass("active")){
    $(".drag_element").removeClass("active");
  }
  else{
    $(".drag_element").removeClass("active");
    $(this).addClass("active");
  }
});
//--------------------关闭菜单------------------
$(document).on("mousedown",".menu_content",function(e){
  e.stopPropagation();
  if(!$(e.target).hasClass("menu") && !$(e.target).parents().hasClass("menu")){
    $(".menu_content").hide();
    $(".drag_element").removeClass("active");
  }
});
//--------------------拖动大小功能---------------------------
var change_handle={'state':false,'target':null}
$(document).on("mousedown",".drag_element .size",function(e){
  change_handle.state=true;
  change_handle.target=e.target;
});
$(document).on("mousemove",function(e){
  if(change_handle.state){
    var eleleft=change_handle.target.parentNode.offsetLeft;
    var x=e.clientX;
    var w=x-eleleft;
    var wid=$(change_handle.target.parentNode.parentNode).width();
    var c=w/wid*100;
    if(c>100){
      c=100;
    }
    $(change_handle.target.parentNode).css("width",c+"%");
  }
});
$(document).on("mouseup",function(e){
  if(change_handle.state){
    change_handle.state=false;
  }
});
//------------------滚动banner----------------------
$(function() {
    $(".banner_container").swiper({
      autoplay:3000,
      autoplayDisableOnInteraction :false
    });
  });
//-----------------调整工具栏位置-------------------
$(function(){
		var header_h=$(".visual_header").height();
		$(".top_padding").css("height",header_h+"px");
	});
//------------------隐藏/显示参考线-----------------
$(".visual_hide_referenceline").click(function(){
		var t=$(".reference_line");
		if(t.hasClass("hide")){
			t.removeClass("hide");
			$("body").css("background-image","url('http://imgs.aijiaijia.com/pc/home/custom/visual/row.png')");
		}
		else{
			t.addClass("hide");
			$("body").css("background-image","none");
		}
});
//--------------------------------------------------
function init_time(element){
  var str=element.attr("data-time");
  if(!str){
    element.attr("data-start",false);
    return false;
  }
  var settime=Date.parse(new Date(str));
  var nowtime=Date.parse(new Date());
  var rangetime=settime-nowtime;
  if(rangetime<=0){
    element.attr("data-start",false);
    return false;
  }
  var day=Math.floor(rangetime/(1000*60*60*24));
  var h=Math.floor(rangetime/(1000*60*60)-day*24);
  var m=Math.floor(rangetime/(1000*60)-day*24*60-h*60);
  var s=Math.floor(rangetime/(1000)-day*24*60*60-h*60*60-m*60);
  if(day<10){
    day="0"+day;
  }
  if(h<10){
    h="0"+h;
  }
  if(m<10){
    m="0"+m;
  }
  if(s<10){
    s="0"+s;
  }
  element.find(".time_day").html(day);
  element.find(".time_h").html(h);
  element.find(".time_m").html(m);
  element.find(".time_s").html(s);
  settime=null,nowtime=null,rangetime=null,day=null,h=null,m=null,s=null;
  setTimeout(function(){
    element.attr("data-start",true);
    init_time(element);
  },1000);
}