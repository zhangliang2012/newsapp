<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/29
 * Time: 16:51
 * API 公共的控制器
 */
namespace app\api\controller;

use app\api\exception\ApiException;
use think\Cache;
use think\Controller;

class Base extends Controller
{
    public $headers = '';//header头信息
    public $from;//分页的起始位置
    public $size;//每页的个数
    public $page;//当前页

    public function _initialize()//初始化方法
    {
       $this->checkRequestAuth();
    }

    /**
     * 检查app每次请求的数据是否合法
     */
    public function checkRequestAuth()
    {
//        halt($this->decrypt("uuj6TmmTvhZT2sJCZt4+ULlgQbw6NAaScUFqv+kWniA="));
        $headers = request()->header();//获取header头信息
//        dump($headers);exit;
        if(empty($headers['sign'])){
            throw new ApiException('sign不存在',400);
        }
        if(empty($headers['apptype']) || !in_array($headers['apptype'],config('apptypes'))){
            throw new ApiException('类型不合法',400);
        }

        if(!$this->checkSignPass($headers)){
            throw new ApiException('授权码sign失败', 401);
        }

        //通过验证后添加到缓存，为以后做唯一性提供条件
        Cache::set($headers['sign'], 1, config('app.app_sign_cache_time'));

        $this->headers = $headers;
    }

    public function encrypt($data = [], $fc="http_build_query")
    {
        ksort($data);//对字段键名升序排序
        $str = $fc($data);//以&符号对数据进行排序
        return openssl_encrypt($str,'AES-128-ECB',"1234567812345678");//对数据进行加密

    }

    public function decrypt($encrypt)
    {
        $encrypted = base64_decode($encrypt);
        $str =  openssl_decrypt($encrypted,'AES-128-ECB',"1234567812345678",OPENSSL_RAW_DATA); // 解密
        return $str;
    }

    /**
     * 检查sign是否正常
     * @param string $sign
     * @param $data
     * @return   bool
     */
    public function checkSignPass($headers)
    {
        $str = $this->decrypt($headers['sign']);
        if(empty($str)){
            return false;
        }
        parse_str($str,$param);//对解密字符串进行转换

        if(!is_array($param) || empty($headers['did']) ||  $param['did'] !== $headers['did']){
            return false;
        }
        if(time()-$param['time']/1000 >config('app.app_sign_time')){
            return false;
        }
        if(Cache::get($headers['sign'])){//sign唯一性
            return false;
        }
        return true;
    }

    /**
     * 获取处理的新闻内容数据
     * @param array $news
     */
    protected function getDealNews($news = [])
    {
        if(empty($news)){
            return [];
        }

        $cats = config('cat.lists');
        foreach($news as $key=>$new){
            $news[$key]['catename'] = $cats[$new['catid']] ? $cats[$new['catid']] : '-';
        }
        return $news;
    }

    public function getFromAndSize($params)
    {
        $this->page = empty($params['page']) ? 1 : $params['page'];
        $this->size = empty($params['size']) ? config('paginate.list_rows') : $params['size'];
        $this->from = ($this->page - 1) * $this->size;
    }
}