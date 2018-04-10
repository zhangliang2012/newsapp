<?php
namespace app\api\controller;

use app\api\exception\ApiException;

class Cat extends Base
{
    /**
     * 栏目接口
     */
    public function read()
    {
        $cats = config("cat.lists");
        $result[] = [
            'catid'=>0,
            'catname'=>'首页'
        ];
        foreach($cats as $catid=>$catname){
            $result[] = [
                'catid'=>$catid,
                'catname'=>$catname
            ];
        }
        return show(config("show_code_success"),'OK',$result,200);
    }

}
