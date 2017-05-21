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

    public static function tableName(){
        return '';
    }

    public function attributeLabels()
    {
        return [
        ];
    }

    public function save(){
        if($this->isNewRecord)
            return $this->_insert();
        else
            return $this->_update();
    }

    private function _insert(){
        $sql = 'insert into ' . $this->tableName . ' set ';
        foreach ($this->attributeLabels as $key => $value){
            if($this->$key){
                $sql .= '`' . $key . '` = "' . $this->$key . '" ,';
            }
        }
        $sql = trim($sql,',');
         if($this->_exec($sql)){
             $this->id = $this->lastInsertId;
            return true;
        }else{
             return false;
         }
    }

    private function _update(){

    }

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

    public function from($tableName = '')
    {
        // TODO: Implement from() method.
        if($tableName){
            $this->tableName = ' ' . strtolower ($this->shortName) . ' ';
        }else{
            $this->tableName = ' ' . $tableName . ' ';
        }
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