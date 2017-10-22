<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Article;
use App\Http\Requests;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $fieldList = [
        'name' => '',
        'path' => '',
        'description' => '',
        'parent_id' => 0,
    ];

    public function __construct()
    {
        $this->category = new Category;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soft = $this->category->onlyTrashed()->count();
        return view('admin.category.index',['soft'=>$soft]);
    }

    public function indexTable(){
        $category = $this->category->with('articles')->get()->toArray();
        $new_category = getCategory($category,true);
        return response()->json($new_category);
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        return view('admin.category.recycle_index');
    }

    public function recycle_indexTable(){
        $category = $this->category->with('articles')->onlyTrashed()->get()->toArray();
        $result = array();
        foreach ($category as $value) {
            $value['article_count'] = count($value['articles']).'篇';
            $result[$value['parent_id']][] = $value;
        }

        $new_category = array();
        if(!empty($result[0])){
            foreach ($result[0] as $v) {
                $new_category[] = $v;
                if(isset($result[$v['id']])){
                    foreach ($result[$v['id']] as $vv) {
                        $vv['name'] = '┕┈┈'.$vv['name'];
                        $new_category[] = $vv;
                    }
                }
            }
        }else{
            foreach ($category as $value) {
                $value['article_count'] = count($value['articles']).'篇';
                $value['name'] = '┕┈'.$value['name'];
                $new_category[] = $value;
            }
        }
        
        return response()->json($new_category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $all_category = getCategory(Category::all()->toArray(),false);
        foreach ($this->fieldList as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }

        $data['allCategory'] = $all_category;

        return view('admin.category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $request_data = $request->postFillData();

        $post = $this->category->create($request_data);

        return redirect()
                        ->route('dashboard.category.index')
                        ->withSuccess('New Category Successfully Created.');
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
        $category = $this->category->find($id);

        $fields = ['id' => $id];
        foreach (array_keys($this->fieldList) as $field) {
            $fields[$field] = $category->$field;
        }
        
        $all_category = getCategory(Category::all()->toArray(),false);
        $data = array();
        foreach ($fields as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }
        $data['allCategory'] = $all_category;

        return view('admin.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = $this->category->findOrFail($id);

        $request_data = $request->postFillData();
        $category->fill($request_data);
        $category->save();

        if ($request->action === 'continue') {
            return redirect()
                            ->back()
                            ->withSuccess('Category saved.');
        }

        return redirect()
                        ->route('dashboard.category.index')
                        ->withSuccess('Category saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if((int)$id==1){
            return redirect()
                        ->route('dashboard.category.index')
                        ->withErrors('默认分类不能被删除');
        }
        $category = $this->category->findOrFail($id);

        $category->delete();

        return redirect()
                        ->route('dashboard.category.index')
                        ->withSuccess('分类删除成功');
    }

    /**
     * 彻底删除分类
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function real_delete($id){
        $category = $this->category->with(['articles','children'])->onlyTrashed()->where('id',$id)->first();
        
        if($category->children()->count()>0){
            return redirect()
                        ->route('dashboard.category.index')
                        ->withErrors($category->name.' 分类下存在子分类，不能被彻底删除');
        }
        
        $category->forceDelete();
        //同时删除关联的文章（文章为软删除，不是真删除）
        $article_ids = $category->articles()->get(['id']);
        $ids = array();
        if(!$article_ids->isEmpty()){
            foreach ($article_ids as $value) {
                $ids[] = $value->id;
            }
            Article::whereIn('id',$ids)->update(['category_id'=>1]);//所有被关联的文章，更新其分类id到通用分类栏目
            Article::destory($ids);
        }
        
        return redirect()
                        ->route('dashboard.category.index')
                        ->withSuccess('分类已被彻底删除');
    }
}
