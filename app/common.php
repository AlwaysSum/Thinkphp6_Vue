<?php
// 应用公共文件

//将数据生成二位数据

use think\facade\Event;
use think\facade\Lang;
use think\facade\Request;

/**
 * 处理插件钩子.
 *
 * @param  string  $event  钩子名称
 * @param  array|null  $params  传入参数
 * @param  bool  $once
 *
 * @return mixed
 */
function hook($event, $params = null, bool $once = false)
{
    return Event::trigger($event, $params, $once);
}



if (!function_exists('treeArray')) {
    /**
     * TP5二级目录转TP6二级目录.
     * @param $data 数据
     * @param int $pid 默认的pid
     * @param string $idName
     * @param string $pidName 父id名称
     * @param string $childName 子类类名
     * @return array
     */
    function treeArray($data, $pid = 0, $idName = 'id', $pidName = 'pid', $childName = 'childs')
    {
        if (!is_array($data)) {
            return [];
        }
        $arr = array();
        foreach ($data as $key => $v) {
            if ($v[$pidName] == $pid) {
                //循环遍历
                $v[$childName] = treeArray($data, $v[$idName], $idName, $pidName, $childName);
                $arr[] = $v;
            }
        }
        return $arr;
    }
}

if (! function_exists('parseName')) {
    function parseName($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);

            return $ucfirst ? ucfirst($name) : lcfirst($name);
        }

        return strtolower(trim(preg_replace('/[A-Z]/', '_\\0', $name), '_'));
    }
}

if (! function_exists('__')) {

    /**
     * 获取语言变量值
     *
     * @param  string  $name  语言变量名
     * @param  array  $vars  动态变量值
     * @param  string  $lang  语言
     *
     * @return mixed
     */
    function __($name, $vars = [], $lang = '')
    {
        if (is_numeric($name) || ! $name) {
            return $name;
        }
        if (! is_array($vars)) {
            $vars = func_get_args();
            array_shift($vars);
            $lang = '';
        }

        return Lang::get($name, $vars, $lang);
    }
}


if (!function_exists('token')) {
    /**
     * 获取Token令牌
     * @param string $name 令牌名称
     * @param mixed  $type 令牌生成方法
     * @return string
     */
    function token(string $name = '__token__', string $type = 'md5'): string
    {
        return Request::buildToken($name, $type);
    }
}
