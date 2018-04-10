<?php
namespace app\api\controller\v1;

use app\api\controller\Base;
use app\api\exception\ApiException;

class Index extends Base
{
    /**
     * 获取首页接口
     * 1、头图   4-6
     * 2、推荐位列表 默认40条
     */
   public function index()
   {
        $heads = model('News')->getIndexHeadNormalNews();
        $heads = $this->getDealNews($heads);

        $position = model('News')->getPositionNormalNews();
        $position = $this->getDealNews($position);

        $result = [
            'heads'=>$heads,
            'position'=>$position
        ];
        return show(config("show_code_success"), 'OK', $result, 200);
   }

}
