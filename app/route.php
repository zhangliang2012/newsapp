<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//\think\Route::post("hello/[:name]",'index/hello');
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//    'hello/[:name]'         => 'index/hello'
//];
use think\Route;

//Route::get('test','api/index/test');
////
//Route::put('test/:id','api/index/update');
//Route::delete('test/:id','api/index/delete');
//
//Route::resource('test','api/index');

Route::get('cats','api/cat/read');
Route::get('api/:ver/cat',"api/:ver.cat/read");
Route::get('api/:ver/index',"api/:ver.index/index");

Route::resource('api/:ver/news','api/:ver.news');

Route::get('api/:ver/rank','api/:ver.rank/index');