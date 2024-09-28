<?php


namespace app\dev\controller;

use app\common\controller\VueController;

class Index extends VueController
{
    
    protected $noNeedLogin = ['login'];
    protected $noNeedRight = ['index', 'logout'];
    protected $layout = '';

    public function index()
    {
        return $this->vue();
    }
}
