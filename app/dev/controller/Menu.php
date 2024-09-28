<?php


namespace app\dev\controller;

use app\dev\model\Menu as ModelMenu;
use app\common\controller\Backend;
use think\facade\Db;

class Menu extends Backend
{

    private $model = null;


    public function _initialize()
    {
        parent::_initialize();
        $this->model = new ModelMenu();
    }

    public function index()
    {

        $menus = $this->model->select();
        $this->assign('navigation_menus', $menus);
        return $this->vue();
    }



    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->param();
            $check = $this->validate($params, 'Menu');
            if ($check !== true) {
                return $this->error($check);
            }
            //处理接口数据
            trace("@请求数据" . json_encode($params));
            trace("@校验结果" . json_encode($check));
            $result = false;
            try {
                Db::startTrans();
                $result = $this->model->save($params);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                return $this->error($e->getMessage());
            }
            if ($result !== false) {
                return $this->success('请求成功');
            } else {
                return $this->error("没有新增任何数据");
            }
        }
        return $this->vue();
    }
}
