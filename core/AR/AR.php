<?php
namespace core\AR;
use core\Config;

/**
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/5/4
 * Time: 23:20
 */
abstract class AR extends \PDO {
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

    /**
     * 查询的字段
     * @var string
     */
    protected $select;

    /**
     * 定义查询字段的抽象方法规范
     * @param array $field 要查询的字段，可以为数组或字符串
     * @return mixed
     */
    abstract public function select($field = []);

    /**
     * 查询的数据表名
     * @var string
     */
    protected $tableName;

    /**
     * 定义查询的数据表抽象方法规范
     * @param string $tableName
     * @return mixed
     */
    abstract public function from($tableName = '');

    /**
     * 查询条件
     * @var string
     */
    protected $where;

    /**
     * 定义查询条件的抽象方法规范
     * @param array $condition
     * @return mixed
     */
    abstract public function where($condition = []);

    /**
     * 追加的查询条件，可以为数组或字符串
     * @var mixed
     */
    protected $addWhere;

    /**
     * 定义追加的查询条件的抽象方法规范
     * @param array $condition
     * @return mixed
     */
    abstract public function addWhere($condition = []);

    abstract public function orderBy($orderBy = []);

    abstract public function groupBy($groupBy = []);

    abstract public function having($condition = []);

    public function queryAll()
    {
        dump($this);die;
    }
}