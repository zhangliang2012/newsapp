<?php
function status($id, $status)
{
//
    $url = url("news/status",['id'=>$id, 'status'=>$status]);
    if($status == 1){
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='news_status(this)'><span class='label label-success radius'>已发布</span></a>";
    }elseif ($status == 0){
        $str = "<a href='javascript:;' title='修改状态' status_url='".$url."' onclick='news_status(this)'><span class='label last-danger radius'>待审</span></a>";
    }
    return $str;
}

function getCatName($catid)
{
    $cats = config("cat.lists");
    return $cats[$catid];
}

