<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/21
 * Time: 19:48
 */
namespace app\admin\model;

use think\Model;

class Privilege extends Model
{
    protected $autoWriteTimestamp =true;//自动添加时间

    public function add($data)//新增
    {
        if(!is_array($data)){
            exception('传递的数据不合法');
        }
        $this->allowField(true)->save($data);
        return $this->id;
    }
}