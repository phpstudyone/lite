<?php
namespace core\AR;
use core\Config;

/**
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/5/4
 * Time: 23:20
 */
class AR extends \PDO {
    private $_dsn;
    private $_username;
    private $_password;
    private $_connect;

    /**
     * 存放执行的sql和结果，用于调试
     *
     * @var array
     */
    private static $_sqlArr;

    public function __construct()
    {
        if($this->_connect){
            return $this->_connect;
        }else{
            $db = Config::getConfig('db');
            $this->_dsn = $db['dsn'];
            $this->_password = $db['password'];
            $this->_username = $db['username'];
            $this->_connect =  parent::__construct($this->_dsn, $this->_username , $this->_password, [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']);
            return $this->_connect;
        }
    }

    /**
     * 直接执行sql返回查询结果
     * @param $sql
     * @return array
     */
    public function queryBySql($sql){
        return $this->_execQuery($sql);
    }

    /**
     * 直接执行sql返回查询结果(私有，框架内部代码调用)
     *
     * @param [type] $sql
     * @return void
     */
    private function _execQuery($sql){
        $result = $this->query($sql,self::FETCH_ASSOC)->fetchAll();
        self::$_sqlArr[] = ['sql'=>$sql,'result'=>$result];
        return $result;
    }

    /**
     * 返回最后一次执行的查询sql
     *
     * @return void
     */
    public function getLastQuerySql(){
        $endArr = end(self::$_sqlArr);
        return isset($endArr['sql']) ? $endArr['sql'] : '';
    }

    /**
     * 获取执行的sql
     *
     * @param boolean $is_end 是否只返回最后一次查询的sql
     * @param boolean $is_result 是否需要返回查询的结果
     * @return void
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
}