<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/23
 * Time: 10:30
 */
namespace app\admin\controller;

class News extends Base
{
    public function index()
    {

    }
    public function add()
    {
        if (request()->isPost()) {//处理post表单
            $data = input('post.');//对数据进行过滤

            $res = $this->validate($data,'News');//对数据进行验证
            if($res !== true){
                return json(array('status'=>5,'mes'=>$res));//验证不通过返回不通过的信息
            }
//            halt($data);
            try{
                $id = model('News')->add($data);
            }catch (\Exception $e){
                return $this->result('',5,$e->getMessage());
            }

            if($id){
                return $this->result(['jump_url'=>url('admin/news/lst')],6,'OK');
            }else{
                return json(array('status'=>5,'mes'=>'id='.$id.'的新增失败'));
            }
        }
        return $this->fetch('', [
            'cats'=>config('cat')
        ]);
    }

    public function lst()
    {
        //第一种方式
//        $news = model('News')->getNews();
        //第二种方式  page  size   from             limit   from  size
        $params = input('param.');
        $query = http_build_query($params);
//        dump($query);

        $where = [];
        //============================搜索功能start===============================
        //时间
        if(!empty($params['start_time']) && !empty($params['end_time']) && $params['end_time'] > $params['start_time']){
            $where['create_time'] = [
                ['gt',strtotime($params['start_time'])],
                ['lt',strtotime($params['end_time'])],
            ];
        }

        if(!empty($params['catid'])){//栏目id
            $where['catid'] = intval($params['catid']);
        }

        if(!empty($params['title'])){//栏目id
            $where['title'] = [
                'like', '%'.$params['title'].'%'
            ];
        }
        //==============================搜索功能结束=========================

        $this->getFromAndSize($params);
        $news = model('News')->getNewsByCondition($where, $this->from, $this->size);//获取列表的数据
        //获取符合的条数计算出多少页
        $total = model('News')->getNewsCount($where);
        $totalPage = ceil($total / $this->size);//总页数
//        echo $where['page'];
        return $this->fetch('',[
            'cats'=>config('cat.lists'),
            'news'=>$news,
            'totalPage'=>$totalPage,
            'curr' => $this->page,
            'start_time'=>empty($params['start_time']) ? '' : $params['start_time'],
            'end_time'=>empty($params['end_time']) ? '' : $params['end_time'],
            'catid' => empty($params['catid']) ?  '' : $params['catid'],
            'title'=> empty($params['title']) ? '': $params['title'],
            'query'=>$query
            ]);
    }

    public function delete($id=0)
    {
        try{
            $res = model("News")->save(['status'=>config("newscode.status_delete")],['id'=>$id]);
        }catch (\Exception $e){
            return $this->result('', 0, '软删除失败');
        }
        if($res){
            return $this->result(['jump_url'=>$_SERVER['HTTP_REFERER']], 1, "删除成功");
        }
        return $this->result("", 0, "删除失败");
    }

    public function status()
    {
        $param = input('param.');
        $status = $param['status'] == config("newscode.status_normal") ? config("newscode.status_padding") : config("newscode.status_normal");
//        $new = model("News")->get($param['id']);
        try{
            $res = model("News")->save(['status'=>$status],['id'=>$param['id']]);
        }catch (\Exception $e){
            return $this->result('', 0, $e->getMessage());
        }

        if($res){
            return $this->result(['jump_url'=>$_SERVER['HTTP_REFERER']], 1, "修改成功");
        }
        return $this->result("", 0, "删除失败");
    }

    public function edit()
    {
        if(request()->isPost()){
            $data = input("post.");
            $res = $this->validate($data,'News');//对数据进行验证
            if($res !== true){
                return json(array('status'=>5,'mes'=>$res));//验证不通过返回不通过的信息
            }

            try{
                $id = model('News')->save($data,['id'=>$data['id']]);
            }catch (\Exception $e){
                return $this->result('',5,$e->getMessage());
            }

            if($id){
                return $this->result(['jump_url'=>url('admin/news/lst')],6,'OK');
            }else{
                return json(array('status'=>5,'mes'=>'id='.$id.'的修改失败'));
            }
        }

        $param = input("param.id");
        $user = model('News')->get($param);
        return $this->fetch('', [
            'cats'=>config('cat.lists'),
            'user'=>$user
        ]);
    }

    public function image()
    {
        echo 123;exit;
    }
}