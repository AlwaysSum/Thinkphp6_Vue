<?php


namespace app\common\controller;


use app\common\controller\BaseController;
use think\facade\View;

class VueController extends BaseController
{

    //插件的CSS和JS引用依赖，可以通过此处控制
    protected $_PLUGINS_CSS = [];
    protected $_PLUGINS_JS = [];


    /**
     * 返回一个vue的页面
     * @param string $template
     * @param array $vars
     * @param string $layout
     * @return string
     * @throws \Exception
     */
    protected function vue(string $template = '', array $vars = [], $layout = '_layout/default')
    {
        //存在vue参数，则返回vue组件
        if (IS_VUE) {
            return $this->vueComponent($template, $vars);
        }

        //模版数据
        View::engine()->layout($layout);
        $request = $this->request;
        $vars["__APP_URL__"] = $request->url(true);
        $this->view->config(['view_suffix' => 'html']);
        // return $this->view->fetch($template, $vars);
        return $this->view->fetch($template, $vars);
    }

    /**
     * 返回一个vue组件
     * @param string $template
     * @param array $vars
     * @return string
     * @throws \Exception
     */
    protected function vueComponent(string $template = '', array $vars = [])
    {
        View::engine()->layout(false);
        $this->view->config([
            'view_suffix' => 'vue',
        ]);
        return $this->view->fetch($template, $vars);
    }

    /**
     * 初始化
     */
    protected function _initialize()
    {
        !defined('IS_VUE') && define('IS_VUE', $this->request->header('vue', false));

        /**
         * 页面的一些相关依赖配置
         */
        $this->assign('vueConfig', [
            "_PLUGINS_CSS" => $this->_PLUGINS_CSS,
            "_PLUGINS_JS" => $this->_PLUGINS_JS,
        ]);
    }
}
