<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/22
 * Time: 18:40
 */
namespace app\admin\controller;

class Privilege extends Base
{
    public function lst()
    {
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost()){//处理表单
            $data = input('post.');

            if(model('Privilege')->get(array('pri_name'=>$data['pri_name']))){
                return json(array('status'=>5,'mes'=>'权限已存在'));
            }

            $res = $this->validate($data,'Privilege');//验证数据
            if(true !== $res){
                return json(array('status'=>5,'mes'=>$res));//验证不通过返回不通过的信息
            }

            $data['status'] = 1;
            try{
                $id = model('Privilege')->add($data);
            }catch (\Exception $e){
                return json(array('status'=>5,'mes'=>$e->getMessage()));
            }
            if($id){
                return json(array('status'=>6,'mes'=>'id='.$id.'的权限新增成功'));
            }else{
                return json(array('status'=>5,'mes'=>'id='.$id.'的权限新增失败'));
            }
        }
        return $this->fetch();//显示表单页面
    }
}