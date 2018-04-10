<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/22
 * Time: 16:09
 */
namespace app\api\lib;

class Time
{
    /**
     * 获取13为时间戳
     * @return int
     */
    public static function get13Timestamp()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }
}