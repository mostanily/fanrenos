<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Album;

use App\Image\ImageRepository;
use File;
use Image;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AlbumController extends Controller
{
    public function __construct($path = 'albums/')
    {
        //读取文件目录
        $this->path_new = storage_path('app/public').'/'.$path;

        //上传的目录
        if(isWindows()){
            $this->upload_path = public_path().config('blog.uploads.webpath').'/'.$path; 
        }else{
            $this->upload_path = config('blog.base_size_path').$path;
        }
        $this->size = config('img_upload.album_size');
        //对尺寸数据的一点处理
        $this->path_size = getSizePath($this->size);

        $this->album = new Album;
    }

    /**
     * 首页
     * @return [type] [description]
     */
    public function index(){
        $soft = $this->album->onlyTrashed()->count();
        return view('admin.album.index',['soft'=>$soft]);
    }

    public function indexTable(){
        $album = $this->album->all();
        foreach ($album as $key => $value) {
            $album[$key]->show_img = page_image_size($value->name,150,'albums');
            $album[$key]->full_img = page_image_size($value->name,1000,'albums');
        }
        return response()->json($album->toArray());
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        return view('admin.album.recycle_index');
    }

    public function recycle_indexTable(){
        $album = $this->album->onlyTrashed()->get();
        foreach ($album as $key => $value) {
            $album[$key]->show_img = page_image_size($value->name,150,'albums');
            $album[$key]->full_img = page_image_size($value->name,1000,'albums');
        }
        return response()->json($album->toArray());
    }

    /**
     * 更新相册内容
     * @param  Request         $request         [description]
     * @param  ImageRepository $imageRepository [description]
     * @return [type]                           [description]
     */
    public function uploadAlbum(Request $request,ImageRepository $imageRepository){
        
        $time = date('Y-m-d H:i:s',time());
        $album_data = array();

        if($request->method()=='GET' && $request->get('uploadType')=='getAlbum'){
            //处理通过ftp批量上传的图片
            $files = app('fileList')->getAlbum($this->path_new);
            if($files['total']>0){
                foreach ($files['list'] as $value) {
                    $album_data[]= array(
                        'name' => $value['name'],
                        'mime' => $value['mime'],
                        'created_at' => $time,
                        'updated_at' => $time,
                    );
                    //将图片移动到对应的目录中
                    foreach ($this->path_size as $k=> $v) {
                        $new_w_h = getNewPicWH($k,$k,$value['w'],$value['h']);
                        $image = Image::make($this->path_new.$value['name'])
                                    ->resize($new_w_h[0],$new_w_h[1])
                                    ->save($this->upload_path.$v.$value['name'] );         
                    }
                    //删除原图
                    if(File::exists($this->path_new.$value['name'])){
                        unlink($this->path_new.$value['name']);
                    }
                }
            }
        }else{
            if($request->hasFile('albumImage')){
                $img = $request->file('albumImage');
                checkdir($this->upload_path,$this->path_size);
                $info = $imageRepository->uploadWithSize($img,$this->upload_path,$this->path_size);
                if(!empty($info)){
                    foreach ($info as $value) {
                        $album_data[]= array(
                            'name' => $value['name'],
                            'mime' => $value['mime'],
                            'created_at' => $time,
                            'updated_at' => $time,
                        );
                    }
                }
            }
        }
        if(!empty($album_data)){
            $this->album->insert($album_data);
            return redirect('/dashboard/album/index')->withSuccess('相册图片更新成功！');
        }
        return redirect('/dashboard/album/index')->withSuccess('没有需要更新的图片！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,ImageRepository $imageRepository)
    {
        $album = $this->album->findOrFail($id);

        $album->delete();

        return redirect()
                        ->route('dashboard.album.index')
                        ->withSuccess('删除成功');
    }

    /**
     * 彻底删除
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function real_delete(ImageRepository $imageRepository,$id){
        $album = $this->album->onlyTrashed()->where('id',$id)->first();
        $old_name = $album->name;
        $album->forceDelete();

        //同时删除原图片
        if(!empty($old_name)){
            $imageRepository->deleteWithSize($this->upload_path, $old_name,$this->size);
        }

        return redirect()
                        ->route('dashboard.album.index')
                        ->withSuccess('图片已被彻底删除');
    }

}
