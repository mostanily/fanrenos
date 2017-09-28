<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use App\Models\CommentThumb;
use App\Http\Requests;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function __construct($path = 'articles/'){
        $this->path = $path;
        $this->comment = new Comment;
        $this->article = new Article;
        $this->thumb = new CommentThumb;
    }

    /**
     * 评论内容
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request){
        $content = $request->get('content');
        if(empty($content) || mb_strlen($content)<10){
            return redirect()->back()->withErrors('评论内容不能为空或者内容少于10个字符！');
        }
        $reply_author = $request->get('comment_reply_author',NULL);
        $reply_author_name = $request->get('comment_reply_author_name',NULL);

        $auth_user_url = auth_user_url(Auth::user()->name);
        
        $new_content = Filter_word($content,$reply_author,$auth_user_url);
        $data = [
            'is_reply_author' =>trim($reply_author),
            'reply_author_name' => $reply_author_name,
            'content' => $new_content,
            'user_id' => Auth::user()->id,
            'commentable_id' => $request->get('commentable_id'),
            'commentable_type' => 'articles'
        ];

        $res = $this->comment->create($data);

        $slug = $request->get('commentable_slug');
        if($res){
            return redirect('blog/'.$slug);
        }
        return redirect()->back()->withErrors('评论失败，请联系管理员！');
    }

    /**
     * [showMoreComment 展示更多评论]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function showMoreComment(Request $request){
        $slug = $request->get('blogSlug');

        $article = $this->article->with(['tags','comments'])->whereSlug($slug)->firstOrFail();
        $raw = json_decode($article->content,true);
        $max_raw = mb_substr($raw['raw'],0,300).'......';
        $article->content_raw = $max_raw;
        $article->page_image = empty($article->page_image) ? '' : $this->path.$article->page_image;

        //回复的内容
        $comments = $article->comments()->with(['user','thumbs'])->orderBy('created_at','asc')->paginate(20);

        //当前登陆用户的id
        if(!Auth::guest()){
            $auth_uid = Auth::user()->id;
        }

        if(!$comments->isEmpty()){
            foreach ($comments as $key => $comment) {
                $author_name = empty($comment->user->nickname) ? $comment->user->name : $comment->user->nickname;
                $avatar = empty($comment->user->avatar) ? asset('images/default.png') : asset('uploads/avatar/60x60/'.$comment->user->avatar);
                $time = Carbon::parse($comment->created_at)->timestamp;
                $date_time = date('Y年m月d日 H:i:s',$time);
                $user_url = auth_user_url($comment->user->name);
                $li_class = '';
                if($key%2!=0){
                    $li_class = 'am-comment-flip';
                }
                $is_has_del = '';
                $is_has_love = '';
                $is_has_comment = '';
                $unlike_content_class = '';
                //只有在用户登陆的情况下才会有回复等功能
                if(!Auth::guest()){
                    //每个评论的点赞信息
                    $thumbs = $comment->thumbs()->get();
                    $thumb_num = '';
                    $like_class = '';
                    $unlike_class = '';
                    $like_user = [];
                    $unlike_user = [];
                    
                    foreach ($thumbs as $k => $thumb) {
                        $status = $thumb->status;
                        $thumb_user_id = $thumb->user_id;
                        if($status==0){
                            $unlike_user[] = $thumb_user_id;
                        }else{
                            $like_user[] = $thumb_user_id;
                        }
                    }
                    if(count($like_user)>0){
                        $thumb_num = '<big style="margin-left:3px;">'.count($like_user).'</big>';
                    }

                    if(in_array($auth_uid, $like_user)){
                        $like_class = 'am-text-success';
                    }
                    if(in_array($auth_uid, $unlike_user)){
                        $unlike_class = 'am-text-danger';
                        //在mydefault.css文件中
                        $unlike_content_class = 'downvoted';
                    }

                    $is_has_comment = '<a class="comment_reply" data-comment="'.$author_name.'" data-comment-name="'.$comment->user->name.'" href="javascript:;" title="回复"><i class="am-icon-mail-reply am-icon-md"></i></a>';
                    if($comment->user_id==$auth_uid){
                        $is_has_del = '<a class="comment_del" data-comment="'.$comment->id.'" href="javascript:;" title="删除"><i class="am-icon-trash am-icon-md"></i></a>';
                    }else{
                        $is_has_love = '<a class="comment_like" data-comment="'.$comment->id.'" href="javascript:;" title="喜欢"><i class="am-icon-smile-o am-icon-md '.$like_class.'"></i>'.$thumb_num.'</a><a class="comment_unlike" data-comment="'.$comment->id.'" href="javascript:;" title="讨厌"><i class="am-icon-frown-o am-icon-md '.$unlike_class.'"></i></a>';
                    }
                }
                $content = json_decode($comment->content,true);
                $comments[$key]->comment_content = $content['html'];
                $comments[$key]->li_class = $li_class;
                $comments[$key]->author_name = $author_name;
                $comments[$key]->avatar = $avatar;
                $comments[$key]->date_time = $date_time;
                $comments[$key]->user_url = $user_url;
                $comments[$key]->is_has_love = $is_has_love;
                $comments[$key]->is_has_del = $is_has_del;
                $comments[$key]->is_has_comment = $is_has_comment;
                $comments[$key]->unlike_content_class = $unlike_content_class;
            }
        }
        
        $data = [
            'title' => config('blog.title'),
            'subtitle' => config('blog.subtitle'),
            'post' => $article,
            'comments' => $comments,
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'reverse_direction' => false,
            'tag' => null,
            'blogSlug' =>$slug,
        ];

        return view('blogs.comment', $data);
    }

    /**
     * 删除某一条评论
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteComment(Request $request){
        $uid = Auth::user()->id;
        $id = $request->get('id');
        $article_id = $request->get('aid');
        $where = [
            'user_id' => $uid,
            'id' => $id,
            'commentable_id' => $article_id,
        ];
        $comment = $this->comment->with('thumbs')->where($where)->first();

        if($comment){
            if($comment->thumbs()->count()>0){
                $ids = $comment->thumbs()->get();
                $id_arr = [];
                foreach ($ids as $key => $value) {
                    $id_arr[] = $value->id;
                }
            }
            $this->thumb->destroy($id_arr);
            $comment->delete();
            $response = ['status'=>'success'];
        }else{
            $response = ['status'=>'failed'];
        }

        return response()->json($response);
    }

    /**
     * 文章评论的点赞情况
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function showThumb(Request $request){
        $thumb_handle = $request->get('thumb_type');
        $comment_id = $request->get('id');
        $uid = Auth::user()->id;

        //默认返回成功状态
        $response = ['status'=>'success'];

        if($thumb_handle=='thumbLike'){
            //执行喜欢操作时，先检查该用户之前是否是不喜欢状态；
            $is_unlike = $this->thumb->where(['user_id' => $uid,'comment_id' => $comment_id])->first();

            if($is_unlike){
                //如果之前为不喜欢状态，则直接修改状态即可
                $res = $is_unlike->update(['status'=>1]);
            }else{
                $data = [
                    'user_id' => $uid,
                    'comment_id' => $comment_id,
                    'status' => 1,
                ];
                $res = $this->thumb->create($data);
            }
            
            //只有出现错误时，才会返回状态给前端；
            //如果没有问题的话，就不返回消息给前端，因为前端的一些样式已经设置完成
            if(!$res){
                $response = ['status'=>'failed','handleType'=>'Likecreate'];
            }
        }else if($thumb_handle=='thumbLikeOver'){
            $res = $this->thumb->where(['user_id' => $uid,'comment_id' => $comment_id])->delete();

            if(!$res){
                $response = ['status'=>'failed','handleType'=>'Likedelete'];
            }
        }else if($thumb_handle=='thumbUnLike'){
            //执行不喜欢操作前，先检查该用户之前是否是喜欢的状态
            $is_like = $this->thumb->where(['user_id' => $uid,'comment_id' => $comment_id])->first();
            if($is_like){
                //如果之前为喜欢状态，则直接修改状态即可
                $res = $is_like->update(['status'=>0]);
            }else{
                $data = [
                    'user_id' => $uid,
                    'comment_id' => $comment_id,
                    'status' => 0,
                ];
                $res = $this->thumb->create($data);
            }

            if(!$res){
                $response = ['status'=>'failed','handleType'=>'UnLikecreate'];
            }

        }else if($thumb_handle=='thumbUnLikeOver'){
            $res = $this->thumb->where(['user_id' => $uid,'comment_id' => $comment_id])->delete();

            if(!$res){
                $response = ['status'=>'failed','handleType'=>'UnLikedelete'];
            }

        }else{
            $response = ['status'=>'errors'];
        }
        return response()->json($response);
    }
}
