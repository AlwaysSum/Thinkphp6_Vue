<?php


namespace app\dev\model;


use think\Model;

class Menu extends Model
{

    protected $table = "base_menu";


    // 追加属性
    protected $append = [
        'path',
    ];

    //路径转化
    public function getPathAttr($value, $data)
    {
        if ($data['type'] === 'vue') {
            return strval(url($data['route'], [], false));
        }
        return $data['route'];
    }
}