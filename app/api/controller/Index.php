<?php

namespace app\api\controller;

use app\BaseController;
use app\common\controller\Api;
use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Utils\BuildSchema;
use think\Db;
use think\Exception;

class Index extends Api
{
    public function index()
    {
        return $this->success();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return $this->success("请求成功", "哈哈哈哈哈哈" . $name);
    }

}
