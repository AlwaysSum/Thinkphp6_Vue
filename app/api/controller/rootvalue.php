<?php
/**
 * hql 接口声明
 */
return [
    'hello' => function ($rootValue, $args, $context) {
        return "hello word!".json_encode($args);
    },
    //接口
    'queryUser' => function ($rootValue, $args, $context) {
        $hql = new \app\api\hql\AdminHql();
        return $hql->query($rootValue, $args, $context);
    },
    'updateUser' => function ($rootValue, $args, $context) {
        $hql = new \app\api\hql\AdminHql();
        return $hql->save($rootValue, $args, $context);
    },
    'deleteUser' => function ($rootValue, $args, $context) {
        $hql = new \app\api\hql\AdminHql();
        return $hql->delete($rootValue, $args, $context);
    },
];