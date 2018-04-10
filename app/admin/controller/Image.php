<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/23
 * Time: 10:30
 */
namespace app\admin\controller;

use think\Request;

class Image extends Base
{
    public function upload()
    {
        $file = Request::instance()->file('file');
        /**
         * 把图片上传到指定文件夹
         */
        $info = $info = $file->move('uploads');

        if($info && $info->getPathname()) {
            //result($data, $code = 0, $msg = '', $type = '', array $header = [])
            return $this->result('/'.$info->getPathname(),1, 'OK', 'json');
        }
        return $this->result('',0, 'error', 'json');
    }


}