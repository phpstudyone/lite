<?php
/**
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/5/5
 * Time: 23:38
 */
namespace core\AR;
class db extends AR {
    /**
     * 直接执行sql返回查询结果
     * @param $sql
     * @return array
     */
    public function queryBySql($sql){
        return $this->_execQuery($sql);
    }

    /**
     * 返回最后一次执行的查询sql
     *
     * @return mixed
     */
    public function getLastQuerySql(){
        $endArr = end(static::$_sqlArr);
        return isset($endArr['sql']) ? $endArr['sql'] : '';
    }

    /**
     * 获取执行的sql
     *
     * @param boolean $is_end 是否只返回最后一次查询的sql
     * @param boolean $is_result 是否需要返回查询的结果
     * @return mixed
     */
    public function getQuerySql($is_end = false,$is_result = false){
        if ($is_end){
            $endArr = end(self::$_sqlArr);
            if($is_result){
                return $endArr;
            }else{
                return isset($endArr['sql']) ? $endArr['sql'] : '';
            }
        }else{
            if($is_result){
                return self::$_sqlArr;
            }else{
                return array_map('reset',self::$_sqlArr);
            }
        }
    }

    public function select($field = [])
    {
        // TODO: Implement select() method.
        return $this;
    }

    public function from($tableName = '')
    {
        // TODO: Implement from() method.
        return $this;
    }

    public function where($condition = [])
    {
        // TODO: Implement where() method.
        return $this;
    }

    public function addWhere($condition = [])
    {
        // TODO: Implement andWhere() method.
        return $this;
    }

    public function groupBy($groupBy = [])
    {
        // TODO: Implement groupBy() method.
        return $this;
    }

    public function orderBy($orderBy = [])
    {
        // TODO: Implement orderBy() method.
        return $this;
    }

    public function having($condition = [])
    {
        // TODO: Implement having() method.
        return $this;
    }
}