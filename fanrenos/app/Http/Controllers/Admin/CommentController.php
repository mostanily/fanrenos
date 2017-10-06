<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->comment = new Comment;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soft = $this->comment->withoutGlobalScopes()->onlyTrashed()->count();
        $comments = $this->comment->with(['user','article'])->get();
        foreach ($comments as $key => $value) {
            $raw = json_decode($value->content,true);
            $max_raw = mb_substr($raw['raw'],0,50).'......';
            $comments[$key]->content_max_raw = $max_raw;
            $comments[$key]->content_raw = $raw['raw'];
            $comments[$key]->select_input = '<label><input class="all_select" type="checkbox" value="'.$value->id.'"></label>';
        }
        return view('admin.comment.index',['comments'=>$comments,'soft'=>$soft]);
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        $comments = $this->comment->with(['user','article'])->withoutGlobalScopes()->onlyTrashed()->get();
        foreach ($comments as $key => $value) {
            $raw = json_decode($value->content,true);
            $max_raw = mb_substr($raw['raw'],0,50).'......';
            $comments[$key]->content_max_raw = $max_raw;
            $comments[$key]->content_raw = $raw['raw'];
        }
        return view('admin.comment.recycle_index',['comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = $this->comment->with(['user','article'])->find($id);
        $content = json_decode($comment->content,true);
        $comment->content_raw = $content['raw'];

        return view('admin.comment.edit', ['comment'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = $this->comment->findOrFail($id);
        $comment->fill(['content'=>$request->get('content')]);
        $comment->save();

        return redirect()
                        ->route('dashboard.comment.index')
                        ->withSuccess('评论编辑成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = $this->comment->findOrFail($id);
        $comment->delete();

        return redirect()
                        ->route('dashboard.comment.index')
                        ->withSuccess('评论删除成功');
    }

    /**
     * 彻底删除评论
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function real_delete($id){
        $comment = $this->comment->onlyTrashed()->where('id',$id)->first();
        $comment->forceDelete();

        return redirect()
                        ->route('dashboard.comment.index')
                        ->withSuccess('评论已被彻底删除');
    }
}
