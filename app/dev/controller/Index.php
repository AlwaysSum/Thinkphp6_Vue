<?php


namespace app\dev\controller;


use app\dev\base\VueController;

class Index extends VueController
{


    public function index()
    {
        return $this->vuePage();
    }

}