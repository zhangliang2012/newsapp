<?php
namespace app\admin\validate;

use think\Validate;

class Privilege extends Validate
{
    protected $rule = [
        'pri_name' => ['require', 'min'=>1],
        'module' => ['require', 'min'=>5],
    ];
}