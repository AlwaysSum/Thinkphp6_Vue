<?php


namespace app\dev\base;


use app\common\controller\BaseController;
use think\facade\View;

class VueController extends BaseController
{

    //插件的CSS和JS引用依赖，可以通过此处控制
    protected $_PLUGINS_CSS = [
        ['name' => 'element-ui', 'path' => 'plugins/element-ui/index.css']
    ];
    protected $_PLUGINS_JS = [
        ['name' => 'element-ui', 'path' => 'plugins/element-ui/index.js']
    ];


    /**
     * 返回一个vue的页面
     * @param string $template
     * @param array $vars
     * @param string $layout
     * @return string
     * @throws \Exception
     */
    protected function vuePage(string $template = '', array $vars = [], $layout = 'default')
    {
        View::engine()->layout('_layout/' . $layout);
        return $this->view->fetch($template, $vars);
    }

    /**
     * 返回一个vue组件
     * @param string $template
     * @param array $vars
     * @return string
     * @throws \Exception
     */
    protected function vue(string $template = '', array $vars = [])
    {
        View::engine()->layout(false);
        $this->view->config(['view_suffix'=> 'vue']);
        return $this->view->fetch($template, $vars);
    }

    /**
     * 初始化
     */
    public function _initialize()
    {
        $modulename = app()->http->getName();
        $controllername = strtolower($this->request->controller());
        $actionname = strtolower($this->request->action());

        /**
         * 页面的一些相关依赖配置
         */
        $this->assign('vueConfig', [
            "_PLUGINS_CSS" => $this->_PLUGINS_CSS,
            "_PLUGINS_JS" => $this->_PLUGINS_JS,
        ]);
    }
}