<?php
//配置文件
return [
    'default_return_type' => 'json',//本模块返回数据默认为json
    'exception_handle'  => '\app\api\exception\Http',//定义的异常类
    'apptypes' => [
        'ios',
        'android',
    ],
    'show_code_success'=>1,
    'show_code_error'=>0,
];