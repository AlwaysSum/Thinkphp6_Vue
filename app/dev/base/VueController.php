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
    protected function vue(string $template = '', array $vars = [], $layout = 'default')
    {
        //存在vue参数，则返回vue组件
        if ($this->request->param('vue')) {
            return $this->vueComponent($template, $vars);
        }

        View::engine()->layout(false);
        $request = $this->request;
        $vars["__APP_URL__"] = url($request->controller() . '/' . $request->action(), array_merge($request->param(), [
            'vue' => true
        ]), "");
        // trace("@@@=>>>" . $vars["__APP_URL__"]);
        $this->view->config(['view_suffix' => 'html']);
        return $this->view->fetch('_layout/index', $vars);
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
        $this->view->config(['view_suffix' => 'vue']);
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
