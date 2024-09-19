<?php

namespace app\common\model;

use think\Model;
use think\db\Query;

/**
 * 模型基类.
 */
class BaseModel extends Model
{


    public function saveData($data = [], $isReplace = true)
    {
        if (is_array($data)) {
            if (count($data) == 1) {
                return $this->replace($isReplace)->save($data[0]);
            } else {
                return $this->saveAll($data, $isReplace);
            }
        }
        return false;
    }


    /**
     * 解析 通用查询数据：
     * {
     *    key:"",
     *    op:"",
     *    value:""
     * }
     * @param array $where
     * @return array
     */
    public function genInputDbWhere($where = [])
    {
        $res = $this;
        foreach ($where as $k => $v) {
            switch ($v['type']) {
                case "and":
                    $res = $res->where($v['key'], $v['op'],
                        count($v['value']) == 1 ? $v['value'][0] : $v['value']);
                    break;
                case "or":
                    $res = $res->whereOr($v['key'], $v['op'],
                        count($v['value']) == 1 ? $v['value'][0] : $v['value']);
                    break;
            }
        }
        return $res;
    }

    /**
     * 查找单条记录.
     *
     * @param mixed $data 主键值或者查询条件（闭包）
     * @param array|string $with 关联预查询
     * @param bool $cache 是否缓存
     *
     * @return array|Model|void|null
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     *
     * @throws \think\db\exception\DataNotFoundException
     */
    public static function get($data, $with = [], $cache = false)
    {
        if (is_null($data)) {
            return;
        }

        if (true === $with || is_int($with)) {
            $cache = $with;
            $with = [];
        }
        $query = static::parseQuery($data, $with, $cache);

        return $query->find($data);
    }

    /**
     * 查找所有记录.
     *
     * @param mixed $data 主键列表或者查询条件（闭包）
     * @param array|string $with 关联预查询
     * @param bool $cache 是否缓存
     *
     * @return \think\Collection
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     *
     * @throws \think\db\exception\DataNotFoundException
     */
    public static function all($data = null, $with = [], $cache = false)
    {
        if (true === $with || is_int($with)) {
            $cache = $with;
            $with = [];
        }
        $query = static::parseQuery($data, $with, $cache);

        return $query->select($data);
    }

    /**
     * 分析查询表达式.
     *
     * @param mixed $data 主键列表或者查询条件（闭包）
     * @param string $with 关联预查询
     * @param bool $cache 是否缓存
     *
     * @return Query
     */
    protected static function parseQuery(&$data, $with, $cache)
    {
        $result = self::withJoin($with)->cache($cache);
        if (is_array($data) && key($data) !== 0) {
            $result = $result->where($data);
            $data = null;
        } elseif ($data instanceof \Closure) {
            call_user_func_array($data, [&$result]);
            $data = null;
        } elseif ($data instanceof Query) {
            $result = $data->withJoin($with)->cache($cache);
            $data = null;
        }

        return $result;
    }
}
