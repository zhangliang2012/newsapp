<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function str_filter($str)
{
    //trim,strip_tags,htmlspecialchars
//    $str = strip_tags($str, '<img>');
//    $str = trim($str);
    return $str;
}

/**
 * //接口api数据输出
 * @param $status   业务状态码
 * @param $message   信息提示
 * @param $data         数据
 * @param $httpcode     http状态码
 * @return array
 */
function show ($status, $message, $data=[], $httpcode=200)
{
    $showdata =  [
        'status'=>$status,
        'msg'=>$message,
        'data'=>$data
    ];
    return json($showdata, $httpcode);
}
