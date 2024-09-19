<?php

namespace app\api\controller;

use app\BaseController;
use app\common\controller\Api;
use GraphQL\GraphQL;
use GraphQL\Utils\BuildSchema;
use think\exception\HttpResponseException;
use think\Response;

class Hql extends Api
{
    public function index()
    {
        //输入参数
        $input = json_decode(file_get_contents('php://input'), true);
        $query = $input['query'];
        $variables = $input['variables'] ?? null;

        //构造graphql
        $schema = BuildSchema::build(file_get_contents(__DIR__ . '/schema.graphqls'));
        //graphql 的接口声明
        $rootValue = include __DIR__ . '/rootvalue.php';
        //执行graphql
        $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variables);
        if (count($result->errors) > 0) {
            foreach ($result->errors as $e) {
                trace($e->getMessage());
            }
            return $this->error("请求失败！", $result);
        } else {
            return $this->success("请求成功!", $result);
        }
    }


    /**
     * 覆盖返回方法
     * @param mixed $msg
     * @param null $data
     * @param int $code
     * @param null $type
     * @param array $header
     */
    protected function result($msg, $data = null, $code = 0, $type = null, array $header = [])
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'time' => time(),
        ];
        //替换data方式
        if (!empty($data)) {
            $result = array_merge($result, json_decode(json_encode($data), true));
        }
        // 如果未设置类型则自动判断
        $type = $type ? $type : ($this->request->param(config('var_jsonp_handler')) ? 'jsonp' : $this->responseType);

        if (isset($header['statuscode'])) {
            $code = $header['statuscode'];
            unset($header['statuscode']);
        } else {
            //未设置状态码,根据code值判断
            $code = $code >= 1000 || $code < 200 ? 200 : $code;
        }
        $response = Response::create($result, $type, $code)->header($header);
        //halt($response);
        throw new HttpResponseException($response);
    }
}
