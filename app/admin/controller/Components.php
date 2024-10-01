<?php


namespace app\admin\controller;


use app\common\controller\VueController;

/**
 * 一些常用的Componets
 * Class Components
 * @package app\school\controller
 */
class Components extends VueController
{

    /**
     * 根据模块和名称获取公用的组件
     */
    public function publicComponents($module, $name)
    {
        return $this->vueComponent($module . DS . $name);
    }
}
