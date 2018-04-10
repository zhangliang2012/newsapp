<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/21
 * Time: 20:14
 */
namespace app\admin\controller;

use app\admin\lib\Auth;
use think\Validate;

class Login extends Base
{
    public function _initialize()//重写初始化方法
    {}
    public function login()
    {
        /**
         * 2、处理表单
         */
        if(request()->isPost()){
            $data = input('post.');//对数据进行过滤
            if (!captcha_check($data['verify'])) {//检测验证码
                $this->error('验证码错误');
            }

            $validate = new Validate([
                'username' => ['require', 'min'=>5],
                'password' => ['require', 'min'=>5],
            ]);
            if (!$validate->check($data)) {//验证数据是否合法
                $this->error($validate->getError());
            }

            //验证用户名和密码
            try {
                $user = model('AdminUser')->get(['username' => $data['username']]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if(!$user || $user->status !== config('usercode.status_normal')){
                $this->error('用户不存在');
            }
            if(Auth::setPassword($data['password']) !== $user->password){
                $this->error('密码错误');
            }

            //更新数据库 登录时间   登录ip
            $udata = [
                'last_login_ip' => request()->ip(),
                'last_login_time' => time()
            ];
            try{
                model('AdminUser')->save($udata, ['id'=>$user->id]);//更新数据
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            session(config('admin.session_user'), $user, config('admin.session_user_scope'));//设置session
            $this->success('登录成功',url('admin/index/index'),'',1);
        }
        /**
         * 1、显示登录页面
         * 判断是否登录，登录过，直接到admin/index/index
         */
        if($this->isLogin()){
            return $this->redirect('admin/index/index');
        }
        return $this->fetch();
    }

    public function logout()
    {
        //t退出登录
        session(null,config('admin.session_user_scope'));
        //跳转到登录页面
        $this->redirect('admin/login/login');
    }
}