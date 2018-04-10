<?php
/**
 * Created by PhpStorm.
 * User: nsfocus
 * Date: 2018/3/29
 * Time: 11:04
 */
namespace app\api\exception;

use think\Exception;

class ApiException extends Exception
{
    public $message = '';
    public $httpcode = 500;
    public $code = 0;
    /**
     * ApiException constructor.
     * @param string $msg     提示信息
     * @param int $httpcode    http状态码
     * @param int $code      业务状态码
     */
    public function __construct($message='',$httpcode=0,$code=0)
    {
        $this->message = $message;
        $this->httpcode = $httpcode;
        $this->code = $code;
    }
}