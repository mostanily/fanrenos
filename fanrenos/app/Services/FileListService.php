<?php
namespace App\Services;
use File;
use Image;
class FileListService
{
    public function __construct()
    {
        //音频文件
        $this->fileAllowAudio = substr(str_replace(".", "|", join("", config('list.fileAllowAudio'))), 1);
        $this->fileAllowImage = substr(str_replace(".", "|", join("", config('list.fileAllowImage'))), 1);
    }

    public function getList($path)
    {
        /* 获取文件列表 */
        $path = isWindows() ? ltrim($path,'/') : $path;

        $files = $this->getfiles($path, $this->fileAllowAudio);

        if (!count($files)) {
            return [
                "state" => "no match file",
                "list" => array(),
                "total" => count($files)
            ];
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = $len - 1, $list = array(); $i < $len && $i >= 0; $i--){
            $list[] = $files[$i];
        }
        $new_list = array();
        foreach ($list as $key => $value) {
            //原统一文件名，音乐名，专辑图片名，歌词名
            $unified_name = $value['name'];

            $audio_pfix = $value['pfix'];
            $image_pfix = '.png';
            $lrc_pfix = '.lrc';

            //生成的新的统一名称（主要是为了去掉中文名称）
            $new_unified_name = createRandomString($unified_name);
            $unified_name=iconv('UTF-8','GBK//IGNORE',$unified_name);

            //判断每个音乐是否存在对应歌词及图片
            $lrc = '';
            $image = '';
            if(File::exists($path.$unified_name.$lrc_pfix)){
                $lrc = getLrc($path.$unified_name.$lrc_pfix);
                rename($path.$unified_name.$lrc_pfix,$path.$new_unified_name.$lrc_pfix);
            }

            if(File::exists($path.$unified_name.$image_pfix)){
                $image = $new_unified_name.$image_pfix;
                rename($path.$unified_name.$image_pfix,$path.$image);
            }
            
            $new_file_name = $new_unified_name.'.'.$audio_pfix;
            //重命名音乐名称
            rename($path.$unified_name.'.'.$audio_pfix,$path.$new_file_name);

            $new_list[] = ['name'=>$new_file_name,'lrc'=>$lrc,'image'=>$image,'unified_name'=>$new_unified_name];
        }

        /* 返回数据 */
        $result = [
            "state" => "SUCCESS",
            "list" => $new_list,
            "total" => count($files)
        ];

        return $result;
    }

    /**
     * 批量处理音乐专辑图片
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public function dealImages($path,$w_h_size=array()){
        $path = isWindows() ? ltrim($path,'/') : $path;
        $files = $this->getfiles($path, $this->fileAllowImage);

        if (!count($files)) {
            return false;
        }
        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = $len - 1, $list = array(); $i < $len && $i >= 0; $i--){
            $list[] = $files[$i];
        }

        //需要处理的图像尺寸
        if(!empty($w_h_size)){
            $w = $w_h_size[0];
            $h = $w_h_size[1];
        }else{
            //默认
            $w = 600;
            $h = 600;
        }
        $has_deal_list = array();
        foreach ($list as $key => $value) {
            $img_full_path = $path.$value['name'].'.'.$value['pfix'];
            $img_info = getimagesize($img_full_path);
            $img_width = $img_info[0];//图片宽
            $img_height = $img_info[1];//图片高
            if($img_width<=$w && $img_height<=$h){
                //处于范围内的图片不做任何修改
                continue;
            }
            //过大的图片进行压缩修改
            $new_w_h = getNewPicWH($w,$h,$img_width,$img_height);
            $re = Image::make($img_full_path)->resize($new_w_h[0],$new_w_h[1])->save();
            $has_deal_list[] = $value['name'].'.'.$value['pfix'];
        }
        if(!empty($has_deal_list)){
            return true;
        }
        return false;
    }

    /**
     * 处理相册的图片
     * @param  [type] $path     [description]
     * @return [type]           [description]
     */
    public function getAlbum($path){
        /* 获取文件列表 */
        $path = isWindows() ? ltrim($path,'/') : $path;

        $files = $this->getfiles($path, $this->fileAllowImage);

        if (!count($files)) {
            return [
                "state" => "no match file",
                "list" => array(),
                "total" => count($files)
            ];
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = $len - 1, $list = array(); $i < $len && $i >= 0; $i--){
            $list[] = $files[$i];
        }
        
        $new_list = array();
        foreach ($list as $key => $value) {
            //原统一文件名
            $unified_name = $value['name'];

            $pfix = $value['pfix'];

            //生成的新的统一名称（主要是为了去掉中文名称）
            $new_unified_name = createRandomString($unified_name);
            $unified_name=iconv('UTF-8','GBK//IGNORE',$unified_name);
            
            $new_file_name = $new_unified_name.'.'.$pfix;
            $img_full_path = $path.$new_file_name;
            //重命名名称
            rename($path.$unified_name.'.'.$pfix,$img_full_path);

            $img_info = Image::make($img_full_path);
            $mime = $img_info->mime();
            $width = $img_info->width();
            $height = $img_info->height();

            $new_list[] = ['name'=>$new_file_name,'mime'=>$mime,'w'=>$width,'h'=>$height];
        }

        /* 返回数据 */
        $result = [
            "state" => "SUCCESS",
            "list" => $new_list,
            "total" => count($files)
        ];

        return $result;
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    protected function getfiles($path, $fileAllowAudio, &$files = array())
    {
        if (!is_dir($path)) {
            return null;
        }
        if(substr($path, -1) != '/') {
            $path .= '/';
        }
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                //IGNORE参数忽视不认识的字符并继续往下读
                $file=iconv('GBK//IGNORE','UTF-8',$file);
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getfiles($path2, $fileAllowAudio, $files);
                } else {
                    if (preg_match("/\.(".$fileAllowAudio.")$/i", $file)) {
                        $file_arr = explode('/', $path2);
                        $file_name = end($file_arr);
                        $pfix_arr = explode('.',$file_name);
                        $pfix = end($pfix_arr);
                        $files[] = array(
                            'name' => $pfix_arr[0],//不带后缀名
                            'pfix' => $pfix,
                        );
                    }
                }
            }
        }
        return $files;
    }

}