<?php
namespace app\api\controller\v1;

use app\api\controller\Base;
use app\api\exception\ApiException;

class Rank extends Base
{
    /**
     * 获取排行榜数据列表
     * 1、获取数据库按照  read-count排序
     *
     * @return array
     */
   public function index()
   {
        try{
            $ranks = model('News')->getRankNormalNews();
            $ranks = $this->getDealNews($ranks);
        }catch (\Exception $e){
            return show(config("show_code_error"), '服务器内部错误', [], 500);
        }
        return show(config("show_code_success"), 'OK', $ranks, 200);
   }

}
