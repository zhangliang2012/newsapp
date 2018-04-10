<?php
namespace app\api\controller;

use app\api\exception\ApiException;
use think\Controller;
use think\Request;
use \app\api\lib\Time as LibTime;

class Time extends Controller
{
    public function index()
    {
        return show(1,'OK',LibTime::get13Timestamp());
    }
}
