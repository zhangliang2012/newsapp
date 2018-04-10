<?php
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    public $from;//分页的起始位置
    public $size;//每页的个数
    public $page;//当前页

    public function _initialize()//初始化方法
    {
        //判断用户是否登录
        if(!$this->isLogin()){//登录成功
            return $this->redirect('admin/login/login');
        }

    }

    public function isLogin()//判断是否登录
    {
        $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));//获取session
        if($user && $user->id){
            return true;
        }
        return false;
    }

    public function getFromAndSize($params)
    {
        $this->page = empty($params['page']) ? 1 : $params['page'];
        $this->size = empty($params['size']) ? config('paginate.list_rows') : $params['size'];
        $this->from = ($this->page - 1) * $this->size;
    }
}