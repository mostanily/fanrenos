<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    public function getCss()
    {
        //前端资源合并
        header("Content-Type:text/html;charset=UTF-8");
        $conn         = "";
        $path_array[] = public_path().'/layui/css/layui.css';
        $path_array[] = public_path().'/css/style.min.css';
        $path_array[] = public_path().'/css/amazeui.min.css';
        $path_array[] = public_path().'/css/app_amaze.min.css';
        $out_put      = public_path().'/css/public.css';//最终生成的文件名称
        foreach ($path_array as $key => $path) {
            if (file_exists($path)) {
                if ($fp = fopen($path, "a+")) {
                    //读取文件
                    $conn .= fread($fp, filesize($path));
                }
            }
        }
        @file_put_contents($out_put, $conn);
    }

    public function getJs()
    {
        //
    }
}
