<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/29
 * Time: 11:04
 */
namespace app\api\exception;

use think\exception\Handle;
use think\exception\HttpException;

class Http extends Handle{

    public $statusCode = 500;
    public function render(\Exception $e){
        if(config('app_debug') == true){
           return parent::render($e);
        }
        if ($e instanceof HttpException) {
            $this->statusCode = $e->getStatusCode();
        } elseif ($e instanceof ApiException) {
            $this->statusCode = $e->httpcode;
        }
        return show(0, $e->getMessage(),[], $this->statusCode);
    }

}