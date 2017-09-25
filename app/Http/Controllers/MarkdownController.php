<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Image\ImageRepository;

class MarkdownController extends Controller
{
    public function __construct($path = 'markdown/')
    {
        $this->date = date('Y-m-d', time());
        $this->upload_path = config('blog.base_size_path') . $path.$this->date.'/';
        $this->call_back_path = config('blog.uploads.webpath').'/'.$path.$this->date.'/';
    }

    /**
     *
     * 上传图片
     * @param  ImageRepository $imageRepository [description]
     * @param  Request         $request         [description]
     * @return [type]                           [description]
     */
    public function uploads(ImageRepository $imageRepository,Request $request){
        $validator = $this->validator($request->input());

        if ($validator->fails()) {
            return '仅支持上传png,gif,jpeg,jpg格式的图片';
        }

        if($request->hasFile('markdownImage')){
            $img = $request->file('markdownImage');
            checkdir($this->upload_path);
            $info = $imageRepository->uploadSingle($img,$this->upload_path);

            $img_info = $this->call_back_path.$info;
        }else{
            $img_info = '没有上传文件，请联系管理员！';
        }

        return $img_info;
    }

    /**
     * 验证上传的图片信息
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function validator(array $data){

        $validator = Validator::make($data, [
                'markdownImage' => 'mimes:png,gif,jpeg,jpg'
            ]);
        return $validator;

    }
}
