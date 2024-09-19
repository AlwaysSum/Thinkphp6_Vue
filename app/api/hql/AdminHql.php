<?php


namespace app\api\hql;


/**
 * Class AdminHql
 * @package app\api\hql
 */
class AdminHql extends BaseHql
{
    public function __construct()
    {
        $this->model = new \app\api\model\Admin();
    }
}