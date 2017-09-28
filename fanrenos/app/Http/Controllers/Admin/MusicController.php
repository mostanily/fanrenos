<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
require (app_path() . '/Libs/Music/getid3/getid3.php');
use App\Image\ImageRepository;
use App\Models\Music;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MusicController extends Controller
{
    public function __construct($path='songs/')
    {
        //读取新的音乐文件，新文件上传位置
        $this->path_new = storage_path('app/public').'/'.$path;
        //播放资源存放路径
        if(isWindows()){
            $this->path_play = public_path().config('blog.uploads.webpath').'/'.$path; 
        }else{
            $this->path_play = config('blog.base_size_path').$path;
        }
        
        $this->music = new Music();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soft = $this->music->onlyTrashed()->count();
        $music = $this->music->all();
        return view('admin.music.index',['musics'=>$music,'soft'=>$soft]);
    }

    /**
     * 回收站
     * @return [type] [description]
     */
    public function recycle_index(){
        $music = $this->music->onlyTrashed()->get();
        return view('admin.music.recycle_index',['musics'=>$music]);
    }

    /**
     * 更新新的音乐文件
     * 不存在更新操作，此处即为添加操作
     * @return [type] [description]
     */
    public function uploadMusic(){
        $info = new \getID3;

        $files = app('fileList')->getList($this->path_new);

        $music_info = array();
        if($files['total']>0){
            foreach ($files['list'] as $key => $value) {
                $name = $value['name'];

                $music_info[$key]['music_name'] = $name;//名称
                
                //对应专辑图片处理
                $image = NULL;
                $music_info[$key]['music_local_image_path'] = NULL;
                if(!empty($value['image'])){
                    $image = $value['image'];
                    $music_info[$key]['music_local_image_path'] = $this->path_new.$value['image'];
                }
                $music_info[$key]['music_image'] = $image;
                
                //歌词处理
                $music_info[$key]['music_local_lrc_path'] = NULL;
                $lrc = NULL;
                if(!empty($value['lrc'])){
                    $lrc = $value['lrc'];
                    $music_info[$key]['music_local_lrc_path'] = $this->path_new.$value['unified_name'].'.lrc';
                }
                $music_info[$key]['music_lrc'] = empty($value['lrc']) ? NULL : $value['lrc'];

                $file = $this->path_new.$name;
                $music_info[$key]['music_local_path'] = $file;//本地音乐存储路径

                $file_info = $info->analyze($file);//分析文件
                $fileformat = $file_info['fileformat'];
                if(isset($file_info['tags']['id3v2'])){
                    $music_info[$key]['music_title'] = $file_info['tags']['id3v2']['title'][0];//标题
                    $music_info[$key]['music_album'] = $file_info['tags']['id3v2']['album'][0];//专辑
                    $music_info[$key]['music_artist'] = $file_info['tags']['id3v2']['artist'][0];//演唱者
                }else{
                    $music_info[$key]['music_title'] = $file_info['tags'][$fileformat]['title'][0];//标题
                    $music_info[$key]['music_album'] = $file_info['tags'][$fileformat]['album'][0];//专辑名称
                    $music_info[$key]['music_artist'] = $file_info['tags'][$fileformat]['artist'][0];//演唱者
                }
                
                $music_info[$key]['music_play_time'] = $file_info['playtime_string'];//播放时长
                $music_info[$key]['music_mime_type'] = $file_info['mime_type'].'(.'.$file_info['fileformat'].')';//文件类型
                $music_info[$key]['music_size'] = human_filesize($file_info['filesize']);//文件大小，单位自动适应
            }
        }

        $music_data = array();
        $time = date('Y-m-d H:i:s',time());
        if(!empty($music_info)){
            foreach ($music_info as $value) {
                $music_data[] = array(
                    'name' => $value['music_name'],
                    'title' => $value['music_title'],
                    'album' => $value['music_album'],
                    'image' => $value['music_image'],
                    'artist' => $value['music_artist'],
                    'play_time' => $value['music_play_time'],
                    'mime_type' => $value['music_mime_type'],
                    'size' => $value['music_size'],
                    'lrc' => $value['music_lrc'],
                    'created_at' => $time,
                    'updated_at' => $time,
                );
                //同时将处理过的文件挪移到播放资源文件夹
                if(!empty($value['music_image'])){
                    rename($value['music_local_image_path'],$this->path_play.$value['music_image']);
                }
                if(!empty($value['music_lrc'])){
                    unlink($value['music_local_lrc_path']);
                }
                rename($value['music_local_path'],$this->path_play.$value['music_name']);
            }
        }
        if(!empty($music_data)){
            $this->music->insert($music_data);
            return redirect('/dashboard/music/index')->withSuccess('更新成功！');
        }

        return redirect('/dashboard/music/index')->withSuccess('没有需要更新的文件！');
    }

    /**
     * 批量处理音乐的大图
     * @return [type] [description]
     */
    public function dealMusicImage(){
        $result = app('fileList')->dealImages($this->path_play);

        if($result){
            return redirect('/dashboard/music/index')->withSuccess('图片修改成功！');
        }
        return redirect('/dashboard/music/index')->withSuccess('没有需要修改的图片！');
    }

    /**
     * 给音乐添加封面图
     * @param  ImageRepository $imageRepository [description]
     * @param  Request         $request         [description]
     * @param  [type]          $id              [description]
     * @return [type]                           [description]
     */
    public function logoUpload(ImageRepository $imageRepository,Request $request,$id){}

    /**
     * 更新音乐歌词
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function lrcUpload(Request $request,$id){
        if($request->hasfile('lrc')){
            $lrc = $request->file('lrc');
            $realPath = $lrc->getRealPath();
            //歌词处理
            $lrcWord = getLrc($realPath);
            $music = $this->music->find($id);
            $music->update(['lrc'=>$lrcWord]);
            return redirect('/dashboard/music/index')->withSuccess('歌词更新成功！');
        }
        return redirect('/dashboard/music/index')->withSuccess('歌词文件不存在，请重试！');
    }

    /**
     * 上传单曲
     * @param  ImageRepository $imageRepository [description]
     * @param  Request         $request         [description]
     * @return [type]                           [description]
     */
    public function musicStore(ImageRepository $imageRepository,Request $request){
        set_time_limit(0);
        $info = new \getID3;
        $music_data = array();
        $lrc = NULL;
        if($request->hasfile('lrc')){
            $lrc = $request->file('lrc');
            $realPath = $lrc->getRealPath();
            //歌词处理
            $lrcWord = getLrc($realPath);
            $lrc = $lrcWord;
        }

        $album_music = $imageRepository->uploadMusic($request,$this->path_play,$info);
        if($album_music){
            $time = date('Y-m-d H:i:s',time());
            $music_data = array(
                'name' => $album_music['music_name'],
                'lrc' => $lrc,
                'title' => $album_music['music_title'],
                'album' => $album_music['music_album'],
                'image' => $album_music['music_image'],
                'artist' => $album_music['music_artist'],
                'play_time' => $album_music['music_play_time'],
                'mime_type' => $album_music['music_mime_type'],
                'size' => $album_music['music_size'],
                'created_at' => $time,
                'updated_at' => $time,
            );

            $this->music->create($music_data);

            return redirect('/dashboard/music/index')->withSuccess('单曲上传成功！');
        }
        return redirect('/dashboard/music/index')->withErrors('音乐文件不存在！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $music = $this->music->findOrFail($id);

        $music->delete();

        return redirect()
                        ->route('dashboard.music.index')
                        ->withSuccess('删除成功');
    }

    /**
     * 彻底删除友链
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function real_delete(ImageRepository $imageRepository,$id){
        $music = $this->music->withoutGlobalScopes()->onlyTrashed()->where('id',$id)->first();
        $old_page_image = $music->image;
        $old_music = $music->name;
        
        $music->forceDelete();

        //同时删除原图片
        if(!empty($old_page_image)){
            $imageRepository->deleteFile($old_page_image,$this->path_play);
        }

        if(!empty($old_music)){
            $imageRepository->deleteFile($old_music,$this->path_play);
        }

        return redirect()
                        ->route('dashboard.music.index')
                        ->withSuccess('音乐已被彻底删除');
    }
}
