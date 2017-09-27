<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Image\ImageRepository;
use App\Models\Link;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    protected $fieldList = [
        'name' => '',
        'link' => '',
        'status' => 1,
    ];

    public function __construct($path = 'links/')
    {
        $this->date = date('Y-m-d', time());
        $this->path = $path;
        $this->upload_path = config('blog.base_size_path') . $path.$this->date.'/';
        $this->del_path = config('blog.base_size_path') . $path;
        $this->link = new Link;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soft = $this->link->withoutGlobalScopes()->onlyTrashed()->count();
        $link = $this->link->all();
        return view('admin.link.index',['links'=>$link,'soft'=>$soft]);
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        $link = $this->link->withoutGlobalScopes()->onlyTrashed()->get();
        return view('admin.link.recycle_index',['links'=>$link]);
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
        
        foreach ($fields as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }
        $data['image'] = old('image', '');
        $data['link_name'] = old('link_name','');

        return view('admin.link.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRepository $imageRepository,Request $request)
    {
        if(!empty($request->get('link_name')) && is_online_url($request->get('link_name'))){
            $this->link->image = $request->get('link_name');
        }else{
            $image = NULL;
            if($request->hasFile('image')){

                $img = $request->file('image');

                checkdir($this->upload_path);

                $info = $imageRepository->uploadSingle($img,$this->upload_path,[20,20]);

                if(File::exists($this->upload_path.$info)){
                    $image = $this->date.'/'.$info;
                }
            }
            $this->link->image = $image;
        }
        

        foreach (array_keys($this->fieldList) as $field) {
            $this->link->$field = $request->get($field);
        }

        $this->link->save();

        return redirect('/dashboard/link/index')->withSuccess('添加成功！');
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

        $links = $this->link->find($id);

        $fieldNames = array_keys($fields);
        $fields = ['id' => $id];
        foreach ($fieldNames as $field) {
            $fields[$field] = $links->$field;
        }
        if(!empty($links->image) && is_online_url($links->image)){
            $fields['link_name'] = $links->image;
            $fields['image'] = $links->image;
        }else{
            $fields['link_name'] = '';
            $fields['image'] = empty($links->image) ? '' : $this->path.$links->image;
        }
        
        $data = array();
        foreach ($fields as $fieldName => $fieldValue) {
            $data[$fieldName] = old($fieldName, $fieldValue);
        }

        return view('admin.link.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRepository $imageRepository,Request $request, $id)
    {
        $link = $this->link->findOrFail($id);

        //判定是否填写了在线的图片链接
        if(!empty($request->get('link_name')) && is_online_url($request->get('link_name'))){
            $link->image = $request->get('link_name');
        }else{
            $old_page_image = $link->image;//old图片
            if($request->hasFile('image')){

                $img = $request->file('image');
                checkdir($this->upload_path);
                $info = $imageRepository->uploadSingle($img,$this->upload_path);

                if(File::exists($this->upload_path.$info)){
                    $image = $this->date.'/'.$info;
                    $link->image = $image;
                    //同时删除原图片
                    if(!empty($old_page_image)){
                        $file_name = explode('/',$old_page_image);
                        $imageRepository->delete($file_name[0],$this->del_path,$file_name[1]);
                    }
                }
            }
        } 

        foreach (array_keys($this->fieldList) as $field) {
            $link->$field = $request->get($field);
        }

        $link->save();

        return redirect()
                        ->route('dashboard.link.index')
                        ->withSuccess('友链保存成功!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = $this->link->findOrFail($id);

        $link->delete();

        return redirect()
                        ->route('dashboard.link.index')
                        ->withSuccess('友链删除成功');
    }

    /**
     * 彻底删除友链
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function real_delete(ImageRepository $imageRepository,$id){
        $link = $this->link->withoutGlobalScopes()->onlyTrashed()->where('id',$id)->first();
        $old_page_image = $link->image;
        
        $link->forceDelete();

        //同时删除原图片
        if(!empty($old_page_image)){
            $file_name = explode('/',$old_page_image);
            $imageRepository->delete($file_name[0],$this->del_path,$file_name[1]);
        }

        return redirect()
                        ->route('dashboard.link.index')
                        ->withSuccess('友链已被彻底删除');
    }
}
