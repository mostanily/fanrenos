<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Category;
use App\Image\ImageRepository;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $fieldList = [
        'category_id' => '',
        'title' => '',
        'subtitle' => '',
        'slug' => '',
        'page_image' => '',
        'content' => '',
        'meta_description' => '',
        'is_draft' => '',
        'is_original' => '',
        'publish_date' => '',
        'publish_time' => '',
        'tags' => [],
    ];

    public function __construct($path = 'articles/')
    {
        $this->date = date('Y-m-d', time());
        $this->path = $path;
        $this->upload_path = config('blog.base_size_path') . $path.$this->date.'/';
        $this->del_path = config('blog.base_size_path') . $path;
        $this->article = new Article;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soft = $this->article->withoutGlobalScopes()->onlyTrashed()->count();
        return view('admin.article.index',['soft'=>$soft]);
    }

    public function indexTable(){
        $article = $this->article->all();
        foreach ($article as $key => $value) {
            $article[$key]->published_at_format = $value->published_at->format('j-M-y g:ia');
        }
        return response()->json($article->toArray());
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        return view('admin.article.recycle_index');
    }

    public function recycle_indexTable(){
        $article = $this->article->withoutGlobalScopes()->onlyTrashed()->get();
        foreach ($article as $key => $value) {
            $article[$key]->published_at_format = $value->published_at->format('j-M-y g:ia');
        }
        return response()->json($article->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = $this->fieldList;

        $data = array();
        $when = Carbon::now()->addHour();
        $data['publish_date'] = $when->format('M-j-Y');
        $data['publish_time'] = $when->format('g:i A');
        $all_tag = Tag::pluck('tag');
        $all_category = Category::all();
        foreach ($fields as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }
        $data['allTags'] = $all_tag;
        $data['allCategory'] = $all_category;

        return view('admin.article.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRepository $imageRepository,PostCreateRequest $request)
    {
        $request_data = $request->postFillData();
        $page_image = NULL;
        if($request->hasFile('page_image')){

            $img = $request->file('page_image');

            checkdir($this->upload_path);

            $info = $imageRepository->uploadSingle($img,$this->upload_path);

            if(File::exists($this->upload_path.$info)){
                $page_image = $this->date.'/'.$info;
            }
        }
        $request_data['page_image'] = $page_image;

        $post = $this->article->create($request_data);
        $post->syncTags($request->get('tags', []));

        return redirect()
                        ->route('dashboard.article.index')
                        ->withSuccess('New Post Successfully Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = $this->fieldList;

        $post = $this->article->with('tags')->find($id);

        $fieldNames = array_keys(array_except($fields, ['tags','content','page_image']));
        $fields = ['id' => $id];
        foreach ($fieldNames as $field) {
            $fields[$field] = $post->$field;
        }
        $content = json_decode($post->content,true);
        $fields['content'] = $content['raw'];
        $fields['page_image'] = empty($post->page_image) ? '' : $this->path.$post->page_image;
        $tags = $post->tags()->get(['tag'])->toArray();
        $fields['tags'] = array();
        if(!empty($tags)){
            foreach ($tags as $k => $v) {
                $fields['tags'][] = $v['tag'];
            }
        }

        $all_tag = Tag::pluck('tag');
        $all_category = Category::all();
        $data = array();
        foreach ($fields as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }
        $data['allTags'] = $all_tag;
        $data['allCategory'] = $all_category;

        return view('admin.article.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRepository $imageRepository,PostUpdateRequest $request, $id)
    {
        $post = $this->article->findOrFail($id);

        $request_data = $request->postFillData();
        $old_page_image = $post->page_image;
        if($request->hasFile('page_image')){

            $img = $request->file('page_image');
            checkdir($this->upload_path);
            $info = $imageRepository->uploadSingle($img,$this->upload_path);

            if(File::exists($this->upload_path.$info)){
                $page_image = $this->date.'/'.$info;
                $request_data['page_image'] = $page_image;
                //同时删除原图片
                if(!empty($old_page_image)){
                    $file_name = explode('/',$old_page_image);
                    $imageRepository->delete($file_name[0],$this->del_path,$file_name[1]);
                }
            }
        }

        $post->fill($request_data);
        $post->save();
        $post->syncTags($request->get('tags', []));

        if ($request->action === 'continue') {
            return redirect()
                            ->back()
                            ->withSuccess('Post saved.');
        }

        return redirect()
                        ->route('dashboard.article.index')
                        ->withSuccess('Post saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->article->findOrFail($id);

        $post->delete();

        return redirect()
                        ->route('dashboard.article.index')
                        ->withSuccess('文章删除成功');
    }

    /**
     * 彻底删除文章
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function real_delete(ImageRepository $imageRepository,$id){
        $post = $this->article->onlyTrashed()->where('id',$id)->first();
        $old_page_image = $post->page_image;
        
        $post->tags()->detach();
        $post->forceDelete();

        //同时删除原图片
        if(!empty($old_page_image)){
            $file_name = explode('/',$old_page_image);
            $imageRepository->delete($file_name[0],$this->del_path,$file_name[1]);
        }

        return redirect()
                        ->route('dashboard.article.index')
                        ->withSuccess('文章已被彻底删除');
    }
}
