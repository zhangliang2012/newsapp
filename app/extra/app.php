<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/22
 * Time: 16:11
 */
return [
    //密码加密眼
    'password_pre_halt' => '!@#afdafhask!@#',

    'controller' =>[
        'admin/privilege/add',
        'aaaa'
    ],

    'aeskey' => '1234567812345678',//aes秘钥，服务端和客户端必须保持一致
    'app_sign_time'=>1000000,//sign过期时间
    'app_sign_cache_time'=>1,//sign缓存过期时间




];