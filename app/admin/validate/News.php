<?php
namespace app\admin\validate;

use think\Validate;

class News extends Validate
{
    protected $rule = [
        'title' => ['require', 'min'=>5],
    ];
}