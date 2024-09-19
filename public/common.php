<?php


// 公共的入口文件配置i


//是否composer
if (! file_exists('../vendor')) {
    exit('根目录缺少vendor,请先composer install');
}

//设置请求环境
define('IS_DEBUG', $_SERVER['SERVER_NAME'] !== 'tfserver.luqingedu.com');
// define('IS_DEBUG',false);

// 定义系统目录分隔符
define('DS', '/');
define('BASE_URL', 'http://'.$_SERVER['SERVER_NAME'].DS);

// 系统根目录,强制转换win反斜杠
define('ROOT_PATH', str_replace('\\', DS, dirname(__FILE__)).DS);
$my_root = empty($_SERVER['SCRIPT_NAME']) ? '' : substr($_SERVER['SCRIPT_NAME'], 1, strrpos($_SERVER['SCRIPT_NAME'], '/'));
define('__MY_ROOT__', defined('IS_ROOT_ACCESS') ? $my_root : str_replace('public'.DS, '', $my_root));
define('__MY_ROOT_PUBLIC__', defined('IS_ROOT_ACCESS') ? DS.$my_root.'public'.DS : DS.$my_root);

// 系统根目录 去除public
define('ROOT', str_replace('public'.DS, '', ROOT_PATH));
// 请求客户端 [pc, h5, ios, android, alipay, weixin, baidu] 默认pc(目前系统为自适应,h5需自行校验)
define('APPLICATION_CLIENT_TYPE', empty($_POST['application_client_type']) ? 'pc' : trim($_POST['application_client_type']));
