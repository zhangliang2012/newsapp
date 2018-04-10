<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/22
 * Time: 16:09
 */
namespace app\admin\lib;

class Auth
{
    /**
     * 设置密码
     */
    public static function setPassword($data)
    {
        return md5($data.config('app.password_pre_halt'));
    }
}