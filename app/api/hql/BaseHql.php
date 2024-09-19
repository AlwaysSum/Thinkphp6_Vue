<?php


namespace app\api\hql;

/**
 * 基本的Hql类
 * Class BaseHql
 * @package app\api\hql
 */
class BaseHql
{

    protected $model = null;


    //--- 通用的基本查询
    public function query($rootValue, $args, $context)
    {
        $res = $this->model->genInputDbWhere($args['where'])->select();
        return $res;
    }


    //---通用的基本更新保存
    public function save($rootValue, $args, $context)
    {
        $res = $this->model->saveData($args['data'], true);
        return $res;
    }


    //---通用的基本删除
    public function delete($rootValue, $args, $context)
    {
        $res = $this->model->genInputDbWhere($args['where'])->delete();
        return $res;
    }

}