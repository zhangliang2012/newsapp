<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/21
 * Time: 19:48
 */
namespace app\api\model;

use think\Model;

class News extends Model
{
    /**
     * 获取首页头图数据
     */
    public function getIndexHeadNormalNews($sum = 4)
    {
        $where = [
            'status' => 1,
            'is_head_figure' => 1,
        ];

        $order = [
            'id'=> 'desc'
        ];

        return $this->field($this->_getListField())->where($where)->order($order)->limit($sum)->select();
    }

    /**
     * 获取推荐的数据
     */
    public function getPositionNormalNews($sum = 30)
    {
        $where = [
            'status'=>1,
            'is_posion'=>1,
        ];

        $order = [
            'id'=>'desc'
        ];

        return $this->field($this->_getListField())->where($where)->order($order)->limit($sum)->select();
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

    /**
     * 根据条件获取数据
     * @param array $condition
     * @param int $from
     * @param int $size
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNewsByCondition($condition = [], $from=0, $size=3)
    {
        $condition['status'] = ['eq',config('newscode.status_normal')];
        $order = ['id' => 'desc'];

        return $this->field($this->_getListField())->where($condition)->order($order)->limit($from,$size)->select();
//        echo $this->getLastSql();exit;
    }

    public function getNewsCount($condition=[])//根据条件获取列表的总数
    {
        $condition['status'] = ['eq',config('newscode.status_normal')];
        return $this->where($condition)->count();
    }

    /**
     * 获取排行榜的数据
     */
    public function getRankNormalNews($sum = 5)
    {
        $where = [
            'status'=>1,
            'is_posion'=>1,
        ];

        $order = [
            'read_count'=>'desc'
        ];

        return $this->field($this->_getListField())->where($where)->order($order)->limit($sum)->select();
    }
}