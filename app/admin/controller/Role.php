<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/22
 * Time: 18:40
 */
namespace app\admin\controller;

class Role extends Base
{
    public function lst()
    {
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){//处理表单
            $data = input('post.');
            halt($data);
        }
        return $this->fetch();//显示表单页面
    }
}