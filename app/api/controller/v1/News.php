<?php
namespace app\api\controller\v1;

use app\api\controller\Base;
use app\api\exception\ApiException;
use think\Db;
use think\Exception;

class News extends Base
{
    public function index()
    {
        //做相关校验使用validate机制（未做）
        $data = input('get.');

//        $condition['catid'] = input('get.catid',0,'intval');
        if(!empty($data['catid'])){
            $condition['catid'] = input('get.catid',0,'intval');
        }
        if(!empty($data['title'])){
            $condition['title'] = ['like','%'.$data['title'].'%'];
        }

        $this->getFromAndSize($data);
        try{
            $total = model("News")->getNewsCount($condition);
            $news = model("News")->getNewsByCondition($condition, $this->from, $this->size);
        }catch (\Exception $e){
            return show(config("show_code_error"), $e->getMessage(), [], 500);
        }
        $result = [
            'total'=>$total,
            'page_total'=>ceil($total / $this->size),
            'list'=>$this->getDealNews($news),
        ];

        return show(config("show_code_success"), 'OK', $result, 200);
    }

    public function read()
    {
        //详情页面  APP-》 1、x.com/3.html   2、接口
        $id = input('param.id', 0, 'intval');
        if(empty($id)){
            throw new ApiException('id is not', 404);
        }
        //通过id获取数据
        try{
            $news = model('News')->get($id);
        }catch (\Exception $e){
            return show(config("show_code_error"), $e->getMessage(), [], 500);
        }
        if(empty($news) || $news->status !== config('newscode.status_normal')){
            throw new ApiException('该新闻不存在', 404);
        }

        //更新阅读数
        try{
            model("News")->where(['id'=>$id])->setInc('read_count');
        }catch (\Exception $e){
            throw new ApiException('无效请求', 400);
        }

        $cats = config('cat.lists');
        $news->catname = $cats[$news->catid];

        return show(config("show_code_success"), 'OK', $news, 200);
    }

}
