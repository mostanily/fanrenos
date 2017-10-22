<?php

    /**
     * 头像地址处理
     * @param  [type] $img  [description]
     * @param  [type] $size [description]
     * @return [type]       [description]
     */
    function avatar_image($img,$size){
        $new_img_url = config('img_upload.avatar_size_path').$size.'x'.$size.'/'.$img;
        if(empty($img)){
            $new_img_url = 'images/default.png';
        }
        return $new_img_url;
    }

    /**
     * 通用尺寸图地址处理
     * @param  [type] $img  [description]
     * @param  [type] $size [description]
     * @return [type]       [description]
     */
    function page_image_size($img,$size,$model){
        
        $new_img_url = config('img_upload.base_size_path').$model.'/'.$size.'x'.$size.'/'.$img;

        return asset($new_img_url);
    }

    /**
     * 登陆用户的个人中心url
     * @param  [type] $auth_name [description]
     * @return [type]            [description]
     */
    function auth_user_url($auth_name){
        return url('/user/'.$auth_name);
    }

    /**
     * Return img url for headers
     */
    function page_image($value = null,$is_index_def=null,$extar=null){
        if (empty($value)) {
            if($is_index_def=='post'){
                $value = config('blog.index_post_def_image');
            }else if($is_index_def=='banner'){
                $value = config('blog.index_banner_def_image');
            }else if($is_index_def=='music'){
                $value = config('blog.music_def_logo');
            }else{
                $value = config('blog.page_image');
            }
        }
        if (!is_online_url($value)) {
            if(!empty($extar)){
                $path = config('blog.uploads.webpath') . '/'.$extar.'/'. $value;
            }else{
                $path = config('blog.uploads.webpath') . '/'. $value;
            }
            $value = asset($path);
        }

        return $value;
    }

    /**
     * 检测字符串是否是完整的网络链接，既：是否含有http/https
     * @param  [type]  $value [description]
     * @return boolean        [description]
     */
    function is_online_url($value){
        if(! starts_with($value, 'http') && $value[0] !== '/'){
            return false;
        }
        return true;
    }

    function checked($value)
    {
        return $value ? 'checked' : '';
    }

    if(!function_exists('lang')) {
        /**
         * Trans for getting the language.
         *
         * @param string $text
         * @param  array $parameters
         * @return string
         */
        function lang($text, $parameters = [])
        {
            return trans('blog.'.$text, $parameters);
        }
    }

    /**
     * 支持UTF-8编码的中文的按照长度分割字符串函数
     * @param  [type]  $str       [description]
     * @param  integer $split_len [description]
     * @return [type]             [description]
     */
    function utf8_str_split($str, $split_len = 1)
    {
        if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
            return FALSE;

        $len = mb_strlen($str, 'UTF-8');
        if ($len <= $split_len)
        {
            return array($str);
        }
        preg_match_all('/.{'.$split_len.'}|[^x00]{1,'.$split_len.'}$/us', $str, $ar);

        return $ar[0];
    }

    /**
     * 屏蔽敏感词
     * @param [type] $str      [description]
     * @param [type] $fileName [description]
     */
    function Filter_word( $str,$reply_author,$auth_user_url)
    {
        //回复型内容，需要给 @author 加个a标签
        //修饰符i表示不区分大小写进行匹配
        $is_need = false;
        if(!empty($reply_author)){
            $str = preg_replace('/'.$reply_author.'/i','<a href="#link-to-user">'.$reply_author.' </a>',$str);
            $is_need = true;
        }
        $path = config('blog.mgc');
        $fileArr = config('blog.mgc_txt');

        foreach ($fileArr as $file) {
            $fullPath = $path.$file;
            $word = checkOneFile($fullPath);
            $str = preg_replace('/'.$word.'/', '***', $str);
        }

        if($is_need){
            $str = preg_replace('/#link-to-user/',$auth_user_url,$str);
        }
        return $str;
    }

    /**
     * 读取单个文件内容，并做处理
     * @param  [type] $fileName 完整文件路径
     * @return [type]           [description]
     */
    function checkOneFile($fileName)
    {
        if ( !($words = file_get_contents( $fileName )) ){     
            return false;
        }

        return preg_replace("/[1,2,3]\r\n|\r\n/i", '|', $words);
    }

    /**
     * 获取歌词文件的内容，并做字符串处理
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    function getLrc($filename){
        if ( !($words = file_get_contents( $filename )) ){     
            return false;
        }
        $new_words = preg_replace("/\./", '@', $words);
        $new_words = preg_replace("/@+([0-9]{1,2})/",'',$new_words);
        $word = str_replace(array("\n","\r"),".",$new_words);

        $word_arr = array();
        $lrc_time = array();
        //处理带有翻译的歌词
        foreach (explode('.',$word) as $key => $value) {
            //截取歌词中的时间
            $time = mb_substr($value,1,5);
            //匹配时间，将时间相同的歌词及翻译歌词放在一起
            if(in_array($time, $lrc_time)){
                $k = array_keys($lrc_time,$time);
                $word_arr[$k[0]] = $word_arr[$k[0]].'-----'.preg_replace("/\[+([0-9]{1,2})+:+([0-9]{1,2})\]/",'',$value);
            }else{
                if(preg_match('/\[+([0-9]{1,2})+:+([0-9]{1,2})\]/', $value)){
                    $lrc_time[$key] = $time;
                }
                $word_arr[$key] = $value;
            }
            
        }
        return implode('.',$word_arr);
    }

    /**
     * 检查文件夹是否已经创建，否则就新建
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    function checkdir($path,$path_size=array()){
        if(!empty($path_size)){
            foreach ($path_size as $size) {
                if(!is_dir($path.$size)){
                    @mkdir($path.$size,0777);
                }
            }
        }else{
            if(!is_dir($path)){
                @mkdir($path,0777);
            }
        }
        
    }

    /**
     * 自定义图片名称
     * @param  [type] $filename [description]
     * @param  [type] $pfix     [description]
     * @return [type]           [description]
     */
    function createUniqueFilename( $path,$filename,$pfix)
    {
        //自定义图片名称
        $str = $filename.mt_rand(100000,999999);
        $pic_name = mb_substr(md5($str),0,12);

        $full_image_path = $path . $pic_name .'.'. $pfix;

        if ( File::exists( $full_image_path ) )
        {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $pic_name . '-' . $imageToken;
        }

        return $pic_name;
    }

    /**
     * 生成一个随机不重复的字符串
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    function createRandomString($string){
        $str = $string.mt_rand(100000,999999);

        return mb_substr(md5($str),0,12);
    }

    /**
     * 判断当前操作系统是否为windows系统
     * @return boolean [description]
     */
    function isWindows(){
        if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
            return true;
        }
        return false;
    }

    /**
     * 根据图片尺寸获取商品主图链接（用于新建文件夹及上传图片）
     * @param  [type] $size [description]
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    function getSizePath($size,$date=''){
        $date_path = '';
        if(!empty($date)){
            $date_path = $date.'/';
        }
        $size_path = array();
        foreach ($size as $value) {
            $size_path[$value] = $value.'x'.$value.'/'.$date_path;
        }
        return $size_path;
    }

    /**
     * 根据尺寸，获取商品主图正确路径(用于删除)
     * @param  [type] $path     [description]
     * @param  [type] $ftp_path [description]暂时注释，用不到
     * @param  [type] $size     [description]
     * @param  [type] $pic_info [description]
     * @return [type]           [description]
     */
    function getSqlSizePath($path,$size,$pic_info){
        $new_path = array();
        if(is_array($pic_info)){
            foreach ($size as $value) {
                foreach ($pic_info as $v) {
                    $new_path['local'][] = $path.$value.'x'.$value.'/'.$v;
                }
            }
        }else{
            foreach ($size as $value) {
                $new_path['local'][] = $path.$value.'x'.$value.'/'.$pic_info;
            }
        }
        return $new_path;
    }

    /**
     * 获取最适合的图片宽高
     * @param  [type] $maxwidth   [图片最大宽]
     * @param  [type] $maxheight  [图片最大高]
     * @param  [type] $pic_width  [图片实际宽]
     * @param  [type] $pic_height [图片实际高]
     * @return [type] array()     [返回最新最合适的图片宽高]
     */
    function getNewPicWH($maxwidth,$maxheight,$pic_width,$pic_height){
        $resizewidth_tag = false;
        $resizeheight_tag = false;
        if($maxwidth && $pic_width>$maxwidth)
        {
            $widthratio = $maxwidth/$pic_width;
            $resizewidth_tag = true;
        }

        if($maxheight && $pic_height>$maxheight)
        {
            $heightratio = $maxheight/$pic_height;
            $resizeheight_tag = true;
        }

        if($resizewidth_tag && $resizeheight_tag)
        {
            if($widthratio<$heightratio){
                $ratio = $widthratio;
            }else{
                $ratio = $heightratio;
            }
        }

        if($resizewidth_tag && !$resizeheight_tag){
            $ratio = $widthratio;
        }
        if($resizeheight_tag && !$resizewidth_tag){
            $ratio = $heightratio;
        }
        if(!$resizeheight_tag && !$resizewidth_tag){
            $ratio = 1;
        }

        $newwidth = $pic_width * $ratio;
        $newheight = $pic_height * $ratio;

        return array($newwidth,$newheight);
    }

    /**
     * 名称过滤
     * @param  [type]  $string          [description]
     * @param  boolean $force_lowercase [description]
     * @param  boolean $anal            [description]
     * @return [type]                   [description]
     */
    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    if(!function_exists('human_filesize')) {
        /**
         * 返回可读性更好的文件尺寸
         * @param $bytes
         * @param int $decimals
         * @return string
         */
        function human_filesize($bytes, $decimals = 2) {
            $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];

            $floor = floor((strlen($bytes)-1)/3);

            return sprintf("%.{$decimals}f", $bytes/pow(1024, $floor)).@$size[$floor];
        }
    }

    /**
     * 返回一个路由的加密字符串，用于缓存的key
     * @return [type] [description]
     */
    function getCacheRememberKey(){
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";
        //以每个访问的路由作为缓存的KEY
        return sha1($fullUrl);
    }

    /**
     * 根据ip获取对应的国家城市等信息(淘宝ip库)
     * @param  [type] $ip [description]
     * @return [type]     [description]
     */
    function getcposition($ip){
 
        $res1 = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=$ip");
        $res1 = json_decode($res1,true);

       if ($res1[ "code"]==0){
            return $res1['data']["country"].$res1['data'][ "region"].$res1['data']["city"]."_".$res1['data'][ "isp"];
        }else{
            return "未知";
        } 
    }

    /**
     * 获取分类列表（用于下拉菜单）
     * @param  [type] $category [description]
     * @return [type]           [description]
     */
    function getCategory($category,$has_child=false){
        $result = getCategoryRecurrence($category,$has_child);
        $new_category = array();
        foreach ($result[0] as $v) {
            $new_category[] = $v;
            if(isset($result[$v['id']])){
                foreach ($result[$v['id']] as $vv) {
                    $vv['name'] = '┕┈┈'.$vv['name'];
                    $new_category[] = $vv;
                }
            }
        }
        return $new_category;
    }

    /**
     * 获取分类列表
     * @return [type] [description]
     */
    function getCategoryRecurrence($category,$has_child=false){
        $result = array();
        foreach ($category as $value) {
            if($has_child){
                $value['article_count'] = count($value['articles']).'篇';
            }
            $result[$value['parent_id']][] = $value;
        }
        return $result;
    }