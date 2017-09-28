<?php

namespace App\Http\Middleware;

use Closure;
use Auth, Cache;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->attributes->set('comData_menu', $this->getMenu());
        return $next($request);
    }

    /**
     * 获取左边菜单栏
     * @return array
     */
    function getMenu()
    {
        //route路由（不包含?后面的参数）
        $http_path = \URL::getRequest()->path();
        $path_arr = explode('/', $http_path);
        $count = count($path_arr);
        $path = implode('.', $path_arr);

        //先判断是否是编辑或回收站路由
        $is_edit_route = false;
        $is_recycle_route = false;
        if($count>1){
            if(end($path_arr)=='edit' || $path_arr[$count-2]=='edit'){
                $is_edit_route = true;
            }
            if(in_array('recycle', $path_arr)){
                $is_recycle_route = true;
            }
        }
        
        $side_nav = config('menu');//获取菜单配置文件
        //找出当前路径对应的菜单，并设置active状态
        $new_side_nav = array();
        foreach ($side_nav as $key => $value) {
            $new_side_nav[$key] = $value;
            $route_1 = $value['route'];
            $model = $value['model'];
            if(!empty($route_1)){
                if($path==$route_1 || $path.'.index'==$route_1){
                    $new_side_nav[$key]['isActive'] = true;
                }
            }else{
                if($is_edit_route || $is_recycle_route){
                    //如果是编辑路由，则默认设置第一个二级菜单active状态（基本都是列表菜单）
                    if($model==$path_arr[1]){
                        $new_side_nav[$key]['isActive'] = true;
                        $new_side_nav[$key]['subTitleNav'][0]['isActive'] = true;
                    }
                }else{
                    foreach ($value['subTitleNav'] as $k => $v) {
                        $route_2 = $v['route'];
                        if($path==$route_2 || $path.'.index'==$route_2){
                            $new_side_nav[$key]['isActive'] = true;
                            $new_side_nav[$key]['subTitleNav'][$k]['isActive'] = true;
                        }
                    }
                }
            }
        }
        return array($new_side_nav,$is_edit_route,$is_recycle_route);
    }
}
