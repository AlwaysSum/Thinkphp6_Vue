<?php


namespace app\admin\validate;


use think\Validate;

class Menu extends Validate
{

    protected $rule = [
        'title' => 'require',
        'route' => 'require',
        'type' => 'require',
    ];


    protected $message = [
        'title' => '名称必须的',
        'route' => '名称必须的',
        'type' => '名称必须的',
    ];
}