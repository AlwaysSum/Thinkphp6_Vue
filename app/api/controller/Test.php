<?php


namespace app\api\controller;


use app\common\controller\Api;

class Test extends Api
{

    function getMenus()
    {
        $data = [
            [
                "name" => "菜单名",
                "icon" => "/icon/aaa.4"
            ]
        ];
        return $this->success("请求成功", $data);
    }

}