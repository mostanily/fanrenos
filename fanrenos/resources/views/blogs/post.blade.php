@extends('layouts.base',[
    'title' => $post->title,
    'meta_description' => $post->meta_description ?: config('blog.description'),
])
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/sinaFaceAndEffec.css')}}" />
<style type="text/css">
    .face-icon{margin-right: 8px;cursor: pointer;}
</style>
@stop
@section('content')
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed blog-content">
    <div class="am-u-sm-12">
        <article class="am-article blog-article-p">
            <div class="am-article-hd">
                <h1 class="am-article-title blog-text-center">{{ $post->title }}</h1>
                @if ($post->subtitle)
                    <h3 class="blog-text-center" style="margin: 0px;">{{ $post->subtitle }}</h3>
                @endif
                <p class="am-article-meta blog-text-center">
                    <span>Post By</span>-
                    <span><a href="javascript:;" class="blog-color">@Mostanily &nbsp;</a></span>-
                    <span data-am-popover="{content: '发布于 {{$post->published_at}}' ,trigger: 'hover focus'}">On {{ $post->published_at->format('F j, Y') }} </span>
                    <span data-am-popover="{content: '创作于 {{$post->created_at}}' ,trigger: 'hover focus'}">Created on {{$post->created_at}}</span>
                    @if($post->view_count>0)
                        <span data-am-popover="{content: '预览' ,trigger: 'hover focus'}" style="margin-left: 20px;"><i class="am-icon-eye"></i> {{$post->view_count}} </span>
                    @endif
                </p>
            </div>
            <div class="am-article-bd">
                @if(!empty($post->page_image))
                    <img src="{{ page_image($post->page_image) }}" alt="" class="blog-entry-img blog-article-margin" onclick="preview_image('{{ page_image($post->page_image) }}')">
                @else
                    <hr>
                @endif
                <div class="col-lg-11 col-md-10">
                    {!! $post->content_html !!}
                </div>
            </div>
        </article>
        <div class="am-g blog-article-widget blog-article-margin">
            <div class="am-u-lg-4 am-u-md-5 am-u-sm-7 am-u-sm-centered blog-text-center">
                <span class="am-icon-tags"> &nbsp;</span>
                @if ($post->tags->count())
                    {!! join(', ', $post->tagLinks()) !!}
                @endif
                <hr>
                <a href="javascript:;"><span data-am-popover="{content: 'MomentD的 QQ-3484368175' ,trigger: 'hover focus'}" class="am-icon-qq am-icon-fw am-primary blog-icon"></span></a>
                <a href="https://github.com/MomentD" target="_blank"><span data-am-popover="{content: 'MomentD的 Github' ,trigger: 'hover focus'}" class="am-icon-github am-icon-fw blog-icon"></span></a>
                <a href="javascript:;"><span class="am-icon-weibo am-icon-fw blog-icon"></span></a>
            </div>
        </div>
        <hr>
        <ul class="am-pagination blog-article-margin">
            @if ($tag && $tag->reverse_direction)
                @if ($post->olderPost($tag))
                    <li class="am-pagination-prev">
                        <a href="{!! $post->olderPost($tag)->url($tag) !!}">
                            <i class="fa fa-long-arrow-left fa-lg"></i>
                            {{$post->olderPost($tag)->title}}{{ $tag->tag ? '--'.$tag->tag : '' }}
                        </a>
                    </li>
                @endif
                @if ($post->newerPost($tag))
                    <li class="am-pagination-next">
                        <a href="{!! $post->newerPost($tag)->url($tag) !!}">
                            {{$post->newerPost($tag)->title}}{{ $tag->tag ? '--'.$tag->tag : '' }}
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </li>
                @endif
            @else
                @if ($post->newerPost($tag))
                    <li class="am-pagination-prev">
                        <a href="{!! $post->newerPost($tag)->url($tag) !!}">
                            <i class="fa fa-long-arrow-left fa-lg"></i>
                            {{$post->newerPost($tag)->title}}{{ $tag ? '--'.$tag->tag : '' }}
                        </a>
                    </li>
                @endif
                @if ($post->olderPost($tag))
                    <li class="am-pagination-next">
                        <a href="{!! $post->olderPost($tag)->url($tag) !!}">
                            {{$post->olderPost($tag)->title}}{{ $tag ? '--'.$tag->tag : '' }}
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
        <h3 class="blog-comment">最新回复</h3>
        <hr>
        {!!  $post->commentList() !!}
        <hr>
        <form class="am-form am-g" id="comment-form" action="javascript:;" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="commentable_id" value="{{$post->id}}">
            <input type="hidden" name="commentable_slug" value="{{$post->slug}}">
            <input type="hidden" class="reply_author" name="comment_reply_author" value="">
            <input type="hidden" class="reply_author_name" name="comment_reply_author_name" value="">
            <h3 class="blog-comment">评论</h3>
            <p class="blog-comment" style="font-size: 12px;">请正确评论，不要发一些不和谐或违法的内容，谢谢照顾！<br>评论支持使用Markdown语法！</p>
            <fieldset>
                <div class="am-form-group">
                    <textarea class="comment_content" rows="7" placeholder="一字千金" name="content"></textarea>
                </div>
                @if (Auth::guest())
                    <p><span class="face-icon" title="添加表情" ><i class="am-icon-smile-o am-icon-md"></i></span><a data-toggle="modal" class="btn btn-default" href="#modal-form" title="登陆后才能评论，点击登陆">登陆后评论</a>
                    </p>
                @else
                    <p><span class="face-icon" title="添加表情" ><i class="am-icon-smile-o am-icon-md"></i></span><button type="button" class="btn btn-primary comment_btn" title="登陆后才能评论">发表评论</button></p>
                @endif
            </fieldset>
        </form>
        <hr>
    </div>
</div>
@stop

@section('js')
{{-- <script type="text/javascript" src="{{ asset('/plugins/layer/layer.min.js') }}"></script> --}}
<script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sinaFaceAndEffec.js')}}"></script>
<script type="text/javascript">
@if (count($errors) > 0)
    var error = "{{$errors->first()}}";
    layer.open({
        type: 1,
        skin: 'layui-layer-lan', //样式类名
        closeBtn: 0, //不显示关闭按钮
        anim: 2,
        area: ['400px', '90px'],
        shadeClose: true, //开启遮罩关闭
        content: '<p style="margin:0px;font-size:18px;text-align:center;">'+error+'</p>',
    });
@endif

// 绑定表情
$('.face-icon').SinaEmotion($('.comment_content'));
window.onload = function(){
    $('li.am-comment').each(function(){
        var inputText = $(this).find('.am-comment-bd').html();
        $(this).find('.am-comment-bd').html(AnalyticEmotion(inputText));
    });
}

$(document).ready(function() {  
    //为超链接加上target='_blank'属性  
    $('.blog-content').find('.am-article-bd').find('a[href^="http"]').each(function() {  
        $(this).attr('target', '_blank');  
    });  
    $('.blog-content').find('.am-article-bd').find('img').click(function(){
        var src = $(this).attr('src');
        preview_image(src);
    });
});

//评论回复
$('.comment_reply').click(function(){
    var at = $(this).attr('data-comment');
    var n = $(this).attr('data-comment-name');
    $('.comment_content').val('@'+at+' ');
    $('.reply_author').val('@'+at+' ');
    $('.reply_author_name').val(n);
});

//评论删除
$('.comment_del').click(function(){
    var id = $(this).attr('data-comment');
    var aid = "{{$post->id}}";
    var url = "{{url('/blog/comment/delete')}}";
    var data = "id="+id+"&aid="+aid;
    myalert('确定需要该条评论么，删除后将不可再出现？','make-sure',url,data);
});

//点赞
var thumb_url = "{{url('/blog/comment/thumb')}}";
$('.comment_like').click(function(){
    var e = $(this);
    var id = e.attr('data-comment');
    var num = 0;
    if(e.find('.like_t')){
        num = Number(e.find('.like_t').text());
    }
    var thumb_type = 'thumbLike'
    if(e.children('i').hasClass('am-text-success')){
        //即取消赞
        thumb_type = 'thumbLikeOver';
        var new_num = num-1;
        if(new_num<=0){
            e.find('.like_t').remove();
        }else{
            e.find('.like_t').html(new_num);
        }
        e.children('i').removeClass('am-text-success');
    }else{
        //即添加赞
        var new_num = num+1;
        if(new_num==1){
            e.append('<big class="like_t" style="margin-left:3px;">1</big>');
        }else{
            e.find('.like_t').html(new_num);
        }
        e.children('i').addClass('am-text-success');
    }
    var old_unlike = false;
    var old_unlike_num = 0;
    if(e.next('.comment_unlike').children('i').hasClass('am-text-danger')){
        e.next('.comment_unlike').children('i').removeClass('am-text-danger');
        e.parents('header').next('div').removeClass('downvoted');
        //同时也需要对不喜欢的数量进行递减
        old_unlike_num = Number(e.next('.comment_unlike').find('.unlike_t').text());
        if(old_unlike_num-1==0){
            e.next('.comment_unlike').find('.unlike_t').remove();
        }else{
            e.next('.comment_unlike').find('.unlike_t').html(old_unlike_num-1);
        }
        old_unlike = true;
    }
    var data='id='+id+'&thumb_type='+thumb_type;

    $.ajax({
        url:thumb_url,
        type:"POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data:data,
        success:function(msg){
            if(msg.status=='failed'){
                var handle = msg.handleType;
                if(handle=='Likecreate'){
                    //用户操作前是没有点赞的，所以要进行回退操作，回复原样
                    if(num==0){
                        e.find('.like_t').remove();
                    }else{
                        e.find('.like_t').html(num);
                    }
                    e.children('i').removeClass('am-text-success');
                    if(old_unlike){
                        e.next('.comment_unlike').children('i').addClass('am-text-danger');
                        e.parents('header').next('div').addClass('downvoted');
                        if(old_unlike_num==1){
                            e.next('.comment_unlike').append('<big class="unlike_t" style="margin-left:3px;">1</big>');
                        }else{
                            e.next('.comment_unlike').find('.unlike_t').html(old_unlike_num);
                        }
                    }
                    
                }else if(handle=='Likedelete'){
                    //用户操作前是有点赞的
                    if(num==1){
                        e.append('<big class="like_t" style="margin-left:3px;">1</big>');
                    }else{
                        e.find('.like_t').html(num);
                    }
                    e.children('i').addClass('am-text-success');
                }
            }else if(msg.status=='errors'){
                myalert('操作失败，可能是网络问题或点击过快，请刷新页面后重试！');
            }
        }
    });
});

//鄙视
$('.comment_unlike').click(function(){
    var e = $(this);
    var id = e.attr('data-comment');

    var thumb_type = 'thumbUnLike';
    var unlike_num = 0;
    if(e.find('.unlike_t')){
        unlike_num = Number(e.find('.unlike_t').text());
    }
    if(e.children('i').hasClass('am-text-danger')){
        //即取消不喜欢
        thumb_type = 'thumbUnLikeOver';
        var new_unlike_num = unlike_num-1;
        if(new_unlike_num<=0){
            e.find('.unlike_t').remove();
        }else{
            e.find('.unlike_t').html(new_unlike_num);
        }
        e.children('i').removeClass('am-text-danger');
        e.parents('header').next('div').removeClass('downvoted');
    }else{
        //即添加不喜欢
        var new_unlike_num = unlike_num+1;
        if(new_unlike_num==1){
            e.append('<big class="unlike_t" style="margin-left:3px;">1</big>');
        }else{
            e.find('.unlike_t').html(new_unlike_num);
        }
        e.children('i').addClass('am-text-danger');
        e.parents('header').next('div').addClass('downvoted');
    }
    var old_like = false;
    var num = 0;
    if(e.prev('.comment_like').find('.like_t')){
        num = Number(e.prev('.comment_like').find('.like_t').text());
    }
    if(e.prev('.comment_like').children('i').hasClass('am-text-success')){
        e.prev('.comment_like').children('i').removeClass('am-text-success');
        if(num!=0){
            var new_num = num-1;
            if(new_num==0){
                e.prev('.comment_like').find('.like_t').remove();
            }else{
                e.prev('.comment_like').find('.like_t').html(new_num);
            }
        }
        old_unlike = true;
    }

    var data='id='+id+'&thumb_type='+thumb_type;

    $.ajax({
        url:thumb_url,
        type:"POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data:data,
        success:function(msg){
            if(msg.status=='failed'){
                var handle = msg.handleType;
                if(handle=='UnLikecreate'){
                    //用户操作前是没有不喜欢的，所以要进行回退操作，回复原样
                    e.children('i').removeClass('am-text-danger');
                    e.parents('header').next('div').removeClass('downvoted');
                    if(old_like){
                        e.prev('.comment_like').children('i').addClass('am-text-success');
                        if(num==1){
                            e.prev('.comment_like').find('.like_t').html('<big class="like_t" style="margin-left:3px;">1</big>');
                        }else{
                            e.prev('.comment_like').find('.like_t').html(num+1);
                        }
                    }
                    
                }else if(handle=='UnLikedelete'){
                    //用户操作前是有不喜欢的
                    if(unlike_num==1){
                        e.append('<big class="unlike_t" style="margin-left:3px;">1</big>');
                    }else{
                        e.find('.unlike_t').html(unlike_num);
                    }
                    e.children('i').addClass('am-text-danger');
                    e.parents('header').next('div').addClass('downvoted');
                }
            }else if(msg.status=='errors'){
                myalert('操作失败，可能是网络问题或点击过快，请刷新页面后重试！');
            }
        }
    });

});

$('.comment_btn').click(function(){
    var c = $.trim($('.comment_content').val());
    var a = "{{url('/blog/comment')}}";
    if(c=='' || c.length<10){
        layer.msg('您没有发表任何意见或者内容少于10个字符，不能评论哦！');
        return false;
    }else{
        $('#comment-form').attr('action',a);
        $('#comment-form').submit();
    }
});
</script>
@stop