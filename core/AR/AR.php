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
    protected static $_sqlArr;

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
     * 直接执行sql返回查询结果(私有，框架内部代码调用)
     *
     * @param [type] $sql
     * @return array
     */
    protected function _execQuery($sql){
        $result = $this->query($sql,self::FETCH_ASSOC)->fetchAll();
        self::$_sqlArr[] = ['sql'=>$sql,'result'=>$result];
        return $result;
    }
}