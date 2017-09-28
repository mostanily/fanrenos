<?php

namespace App\Image;

use Illuminate\Http\Request;
use File;
use Image;

class ImageRepository{
    /**
     * 适用于Markdown编辑器上传图片以及其他单图上传类
     * @param  [type] $photo       [description]
     * @param  [type] $upload_path [description]
     * @param  [type] $w_h_size    [description]
     * @return [type]              [description]
     */
    public function uploadSingle($photo,$upload_path,$w_h_size=array()){
        
        $originalName = $photo->getClientOriginalName();
        //取得图片的后缀
        $pfix = $photo->getClientOriginalExtension();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);
        $filename = sanitize($originalNameWithoutExt);
        //自定义图片名称（路径随意选择一个尺寸即可，每个尺寸下的图片名称都是一样的）
        $pic_name = createUniqueFilename($upload_path,$filename,$pfix);

        $filenameExt = $pic_name .'.'.$pfix;

        //原图（等上传完毕，会删除此图）
        $original_pic = Image::make( $photo )->save($upload_path.'normal_'.$filenameExt);

        $origi_w = $original_pic->width();
        $origi_h = $original_pic->height();

        if(!empty($w_h_size)){
            $w = $w_h_size[0];
            $h = $w_h_size[1];
        }else{
            //默认
            $w = 1000;
            $h = 600;
        }

        $new_w_h = getNewPicWH($w,$h,$origi_w,$origi_h);
        $image = Image::make($original_pic)
                    ->resize($new_w_h[0],$new_w_h[1])
                    ->save($upload_path.$filenameExt );
        if($image){
            $filenameInfo = $filenameExt;//返回的图片信息
            //上传成功，删除最开始的原始图
            unlink($upload_path.'normal_'.$filenameExt);//删除原始图
        }else{
            $filenameInfo = '网络或其他原因导致上传失败，请重试！';
        }
        return $filenameInfo;
    }

    /**
     * 上传单曲处理
     * @param  [type] $request     [description]
     * @param  [type] $upload_path [description]
     * @param  array  $w_h_size    [description]
     * @return [type]              [description]
     */
    public function uploadMusic($request,$upload_path,$getID3,$w_h_size=array()){
        //专辑图片默认尺寸 600*600
        $music_info = array();
        if($request->hasfile('music-file')){
            $file = $request->file('music-file');

            $filename = $file->getClientOriginalName();//文件名
            $pfix = $file->getClientOriginalExtension();//文件后缀
            $realPath = $file->getRealPath();//临时文件绝对路径
            //音频文件数据处理
            $file_info = $getID3->analyze($realPath);//分析文件
            $fileformat = $file_info['fileformat'];
            if(isset($file_info['tags']['id3v2'])){
                $music_info['music_title'] = $file_info['tags']['id3v2']['title'][0];//标题
                $music_info['music_album'] = $file_info['tags']['id3v2']['album'][0];//专辑名称
                $music_info['music_artist'] = $file_info['tags']['id3v2']['artist'][0];//演唱者
            }else{
                $music_info['music_title'] = $file_info['tags'][$fileformat]['title'][0];//标题
                $music_info['music_album'] = $file_info['tags'][$fileformat]['album'][0];//专辑名称
                $music_info['music_artist'] = $file_info['tags'][$fileformat]['artist'][0];//演唱者
            }

            $music_info['music_play_time'] = $file_info['playtime_string'];//播放时长
            $music_info['music_mime_type'] = $file_info['mime_type'].'(.'.$file_info['fileformat'].')';//文件类型
            $music_info['music_size'] = human_filesize($file_info['filesize']);//文件大小，单位自动适应

            //创建一个统一名称，音乐名称及专辑图片名称共用
            $new_unified_name = createRandomString($filename);

            $music_info['music_name'] = $new_unified_name.'.'.$pfix;//名称

            //上传到对应位置
            $res = move_uploaded_file($realPath, $upload_path.$new_unified_name.'.'.$pfix);
            //音乐主体文件上传成功后再判断专辑封面图问题
            if($res){
                $music_info['music_image'] = NULL;
                if($request->hasfile('album')){
                    $album_image = $request->file('album');
                    $album_pfix = $album_image->getClientOriginalExtension();//文件后缀
                    $original_pic = Image::make( $album_image )->save($upload_path.'normal_'.$new_unified_name.'.'.$album_pfix);

                    $origi_w = $original_pic->width();
                    $origi_h = $original_pic->height();

                    if(!empty($w_h_size)){
                        $w = $w_h_size[0];
                        $h = $w_h_size[1];
                    }else{
                        //默认
                        $w = 600;
                        $h = 600;
                    }

                    $new_w_h = getNewPicWH($w,$h,$origi_w,$origi_h);
                    $image = Image::make($original_pic)
                                ->resize($new_w_h[0],$new_w_h[1])
                                ->save($upload_path.$new_unified_name.'.'.$album_pfix );
                    
                    $music_info['music_image'] = $new_unified_name.'.'.$album_pfix;
                    unlink($upload_path.'normal_'.$new_unified_name.'.'.$album_pfix);//删除原始图
                }
                return $music_info;
            }
            return false;
        }else{
            return false;
        }
        
    }

    /**
     * 删除图片
     * Delete Image From Session folder, based on original filename
     */
    public function delete($date,$Filename, $path)
    {
        if(is_array($Filename) && is_array($date)){
            foreach ($Filename as $key => $value) {
                $full_path = $path .$date[$key].'/'. $value;
                if (File::exists($full_path)){
                    File::delete( $full_path);
                }
            }
        }else{
            $full_path = $path .$date.'/'. $Filename;
            if (File::exists($full_path)){
                File::delete( $full_path);
            }
        }
        return true;
    }

    /**
     * 删除文件
     * @param  [type] $filename [description]
     * @param  [type] $path     [description]
     * @return [type]           [description]
     */
    public function deleteFile($filename,$path){
        if(is_array($filename)){
            foreach ($filename as $value) {
                $full_path = $path . $value;
                if (File::exists($full_path)){
                    File::delete( $full_path);
                }
            }
        }else{
            $full_path = $path . $filename;
            if (File::exists($full_path)){
                File::delete( $full_path);
            }
        }
        return true;
    }

    /**
     * 上传带尺寸的套图，单图上传
     * @param  [type] $photo       [description]
     * @param  [type] $upload_path [description]
     * @param  [type] $path_size   [description]
     * @return [type]              [description]
     */
    public function uploadSingleWithSize($photo,$upload_path,$path_size){
        $originalName = $photo->getClientOriginalName();
        //取得图片的后缀
        $pfix = empty($photo->getClientOriginalExtension()) ? 'png' : $photo->getClientOriginalExtension();

        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);
        $filename = sanitize($originalNameWithoutExt);
        //自定义图片名称（路径随意选择一个尺寸即可，每个尺寸下的图片名称都是一样的）
        $pic_name = createUniqueFilename($upload_path.'200x200/',$filename,$pfix);

        $filenameExt = $pic_name .'.'.$pfix;

        //原图（等上传完毕，会删除此图），最终只会保留3套
        $original_pic = Image::make( $photo )->save($upload_path.'normal_'.$filenameExt);

        $origi_w = $original_pic->width();
        $origi_h = $original_pic->height();

        foreach ($path_size as $k => $v) {
            $new_w_h = getNewPicWH($k,$k,$origi_w,$origi_h);
            $image = Image::make($original_pic)
                        ->resize($new_w_h[0],$new_w_h[1])
                        ->save($upload_path.$v.$filenameExt );

        }
        $filename_arr = $filenameExt;//返回的图片信息，用于存入数据库中
        //上传成功，删除最开始的原始图
        unlink($upload_path.'normal_'.$filenameExt);//删除原始图

        return $filename_arr;
    }

    public function deleteWithSize($path, $file_info,$size){
        //套图删除
        $del_path = getSqlSizePath($path,$size,$file_info);
        foreach ($del_path['local'] as $key => $value) {
            if(File::exists($value)){
                File::delete($value);
            }
        }
        return true;
    }
}