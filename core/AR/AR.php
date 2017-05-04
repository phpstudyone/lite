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
        return $this->query($sql,self::FETCH_ASSOC)->fetchAll();
    }
}