<?php
/**
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/5/5
 * Time: 23:36
 */
namespace core\AR;

class ArModel extends AR {

    public $id;
    /**
     * @var array 数据表的属性数组
     */
    public $attributeLabels;

    /**
     * @var bool 是否新的ar对象
     */
    public $isNewRecord;

    public function __construct()
    {
        $this->tableName = $this->tableName();
        $this->attributeLabels = $this->attributeLabels();
        $this->isNewRecord = true;
        if(!empty($this->attributeLabels)){
            foreach ($this->attributeLabels as $key => $value){
                $this->$key = null;
            }
        }
        return parent::__construct();
    }

    /**
     * @return string
     */
    public static function tableName(){
        return '';
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * @param array $condition
     * @return array|bool|mixed
     */
    public static function find($condition = []){
        $that = new static();
        $that->select();
        $that->where($condition);
        $result = $that->all();
        if($result){
            $models = [];
            foreach ($result as $value){
                $model = new static();
                $model->isNewRecord = false;
                foreach ($value as $k => $v){
                    $model->$k = $v;
                }
                $models[] = $model;
            }
            if(count($models) == 1)
                return $models[0];
            else return $models;
        }else
            return false;
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

        if($this->tableName)
            $sql .= ' from ' . $this->tableName;

        if($this->where){
            $sql .= $this->where;
        }

        if($this->limit)
            $sql .= ' limit ' . $this->limit;
        return $this->_execQuery($sql);
    }

    /**
     * 保存model至数据表
     */
    public function save(){
        if($this->isNewRecord)
            return $this->_insert();
        else
            return $this->_update();
    }

    /**
     * @return bool
     */
    private function _insert(){
        $sql = 'insert into ' . $this->tableName . ' set ';
        foreach ($this->attributeLabels as $key => $value){
            if($this->$key){
                $sql .= '`' . $key . '` = "' . $this->$key . '" ,';
            }
        }
        $sql = trim($sql,',');
        if($this->_exec($sql,static::CURD_MODEL_C)){
             $this->id = $this->lastInsertId;
            return true;
        }else{
             return false;
         }
    }

    /**
     * @return bool
     */
    private function _update(){
        $sql = 'update ' . $this->tableName . ' set ';
        foreach ($this->attributeLabels as $key => $value){
            if($this->$key){
                $sql .= '`' . $key . '` = "' . $this->$key . '" ,';
            }
        }
        $sql = trim($sql,',');
        $sql .= ' where id = ' . $this->id;
        return $this->_exec($sql,static::CURD_MODEL_U);
    }

    /**
     * @param array $field
     * @return $this
     */
    public function select($field = [])
    {
        // TODO: Implement select() method.c
        if (empty($field) && $this->attributeLabels){
            foreach ($this->attributeLabels as $key => $value){
                $this->select .= ' `' . $key . '` ,';
            }
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
        if($tableName){
            $this->tableName = ' ' . $tableName . ' ';
        }else{
            $this->tableName = ' ' . strtolower ($this->shortName) . ' ';
        }
        return $this;
    }

    /**
     * @param array $condition
     * @return $this
     */
    public function where($condition = [])
    {
        if($condition){
            $this->where = ' where ';
            // TODO: Implement where() method.
            foreach ($condition as $key => $value){
                $this->where .= ' `' . $key . '` = "' . addslashes($value) . '" and';
            }
            $this->where = trim($this->where,'and');
        }

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
        return $this;
    }
}