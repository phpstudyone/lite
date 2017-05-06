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

    /**
     * @param array $field
     * @return $this
     */
    public function select($field = [])
    {
        // TODO: Implement select() method.
        if (empty($field)){
            $this->select = ' * ';
        }elseif (is_array($field)){
            foreach ($field as $key => $value){
                if (is_numeric($key)){
                    $this->select .= ' `' . $value . '` ,';
                }else{
                    $this->select .= ' `' . $value . '` as ' . $key . ' ,';
                }
            }
        }elseif (is_string($field)){
            $this->errCode = '1001';
        }
        $this->select = trim($this->select,',');
        return $this;
    }

    /**
     * @param string $tableName
     * @return $this
     */
    public function from($tableName = '')
    {
        // TODO: Implement from() method.
        $this->tableName = ' ' . $tableName . ' ';
        return $this;
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function where($condition = [])
    {
        // TODO: Implement where() method.
        return $this;
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function addWhere($condition = [])
    {
        // TODO: Implement andWhere() method.
        return $this;
    }

    /**
     * @param array $groupBy
     * @return $this
     */
    public function groupBy($groupBy = [])
    {
        // TODO: Implement groupBy() method.
        return $this;
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy($orderBy = [])
    {
        // TODO: Implement orderBy() method.
        return $this;
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function having($condition = [])
    {
        // TODO: Implement having() method.
        return $this;
    }

    /**
     * @param $offset
     * @param $rows
     * @return $this
     */
    public function limit($offset = null, $rows = null)
    {
        // TODO: Implement limit() method.
        if(!$offset)
            $this->limit = null;
        elseif (is_numeric($offset)){
            $this->limit = ' ' . $offset . ' ';
            if($rows && is_numeric($rows))
                $this->limit .= ' , ' . $rows . ' ';
        }
        return $this;
    }

    /**
     * 返回查询的数组
     * @return array
     */
    public function all()
    {
        $sql = 'select ';
        if($this->select)
            $sql .= $this->select;

        if($this->where){

        }

        if($this->tableName)
            $sql .= ' from ' . $this->tableName;
        if($this->limit)
            $sql .= ' limit ' . $this->limit;
        return $this->_execQuery($sql);
    }
}