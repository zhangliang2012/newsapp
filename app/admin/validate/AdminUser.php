<?php
namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        'username' => ['require', 'min'=>5],
        'password' => ['require', 'min'=>5],
        'password2' => ['require', 'confirm'=>'password'],
    ];
}