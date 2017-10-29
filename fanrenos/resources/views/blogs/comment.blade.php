@extends('layouts.base',[
    'title' => $post->title.'|所有评论',
    'meta_description' => $post->meta_description ?: config('blog.description'),
])
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/sinaFaceAndEffec.css')}}" />
<style type="text/css">
    .face-icon{margin-right: 8px;cursor: pointer;}
</style>
@stop
@section('content')
<div class="am-g am-g-fixed blog-fixed">
    <div class="am-u-md-12 am-u-sm-12">
        <article class="am-g blog-entry-article">
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <img src="{{page_image($post->page_image,'post')}}" alt="" class="am-u-sm-12" onclick="preview_image('{{ page_image($post->page_image,"post") }}')" style="max-height: 270px;">
            </div>
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                <span>Post By</span>
                <span><a href="javascript:;" class="blog-color"> @Mostanily &nbsp;</a></span>
                <br>
                <span data-am-popover="{content: '发布于 {{$post->published_at}}' ,trigger: 'hover focus'}">On {{ $post->published_at->format('F j, Y') }}</span>
                <span>
                    @if ($post->tags->count())
                        in {!! join(', ', $post->tagLinks()) !!}
                    @endif
                </span>
                <h1><a href="{{ $post->url($tag) }}">{{ $post->title }}</a></h1>
                @if ($post->subtitle)
                    <h3 style="margin: 0px;">{{ $post->subtitle }}</h3>
                @endif
                <p>{{$post->content_raw}}</p>
                <p><a href="" class="blog-continue">continue reading</a></p>
            </div>
        </article>
        @if ($post->comments->count())
            <h3 class="blog-comment">最新回复</h3>
            <ul class="am-comments-list am-comments-list-flip">
                @foreach($comments as $k => $comment)
                    <li class="am-comment {{$comment->li_class}}">
                        <a href="{{$comment->user_url}}"><img alt="{{$comment->author_name}}" src="{{$comment->avatar}}" class="am-comment-avatar" width="48" height="48" /></a>
                        <div class="am-comment-main">
                            <header class="am-comment-hd">
                                <div class="am-comment-meta">
                                    <i class="am-icon-user"></i>
                                    <a href="{{$comment->user_url}}" class="am-comment-author">{!!$comment->author_name.$comment->role_tag!!}</a>
                                    评论于 <time title="{{$comment->date_time}}">{{$comment->created_at}}</time>
                                    <a href="#reply" class="reply-floor">#{{($k+1)}}</a>
                                </div>
                                <div class="am-comment-actions">
                                    {!!$comment->is_has_love.$comment->is_has_del.$comment->is_has_comment!!}
                                </div>
                            </header>
                            <div class="am-comment-bd {{$comment->unlike_content_class}}">
                                <p>{!!$comment->comment_content!!}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>还没有任何评论哦！赶快来抢个沙发啦！</p>
        @endif
        {!! $comments->appends(['blogSlug'=>$blogSlug])->render() !!}
        <hr>
        <form class="am-form am-g" id="comment-form" action="javascript:;" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="commentable_id" value="{{$post->id}}">
            <input type="hidden" name="commentable_slug" value="{{$post->slug}}">
            <input type="hidden" class="reply_author" name="comment_reply_author" value="">
            <input type="hidden" class="reply_author_name" name="comment_reply_author_name" value="">
            <h3 class="blog-comment">评论</h3>
            <p class="blog-comment" style="font-size: 12px;">请正确评论，不要发一些不和谐或违法的内容，谢谢照顾！<br>评论支持使用Markdown语法</p>
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
//表情解析
window.onload = function(){
    $('li.am-comment').each(function(){
        var inputText = $(this).find('.am-comment-bd').html();
        $(this).find('.am-comment-bd').html(AnalyticEmotion(inputText));
    });
}

$('.comment_reply').click(function(){
    var at = $(this).attr('data-comment');
    var n = $(this).attr('data-comment-name');
    $('.comment_content').val('@'+at+' ');
    $('.reply_author').val('@'+at+' ');
    $('.reply_author_name').val(n);
});

$('.comment_del').click(function(){
    var id = $(this).attr('data-comment');
    var aid = "{{$post->id}}";
    var url = "{{url('/blog/comment/delete')}}";
    var data = "id="+id+"&aid="+aid;
    myalert('确定需要该条评论么，删除后将不可再出现？','make-sure',url,data);
});

var thumb_url = "{{url('/blog/comment/thumb')}}";
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