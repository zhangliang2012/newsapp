<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/21
 * Time: 19:48
 */
namespace app\admin\model;

use think\Model;

class News extends Model
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

    public function getNews($data = [])
    {
        $data['status'] = [
            'neq',config('newscode.status_delete')
        ];
        $order = ['id' => 'desc'];
        $result = $this->where($data)->order($order)->paginate();
//        echo $this->getLastSql();
        return $result;
    }

    public function getNewsByCondition($condition = [], $from=0, $size=3)
    {
        $condition['status'] = ['neq',config('newscode.status_delete')];
        $order = ['id' => 'desc'];
//        $from = ($condition['page'] - 1) * $condition['size'];
        return $this->field($this->_getListField())->where($condition)->order($order)->limit($from,$size)->select();
//        echo $this->getLastSql();
    }

    public function getNewsCount($condition=[])//根据条件获取列表的总数
    {
        $condition['status'] = ['neq',config('newscode.status_delete')];
        return $this->where($condition)->count();
    }

    /**
     * 通用化获取参数的数据字段
     */
    private function _getListField()
    {
        return [
            'id',
            'catid',
            'image',
            'title',
            'read_count',
            'update_time',
            'create_time',
            'is_posion',
            'status'
        ];
    }
}