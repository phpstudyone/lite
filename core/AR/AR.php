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

    public $lastInsertId;
    public $errCode;

    public $_tablePrefix;

    //sql执行类型 create
    const CURD_MODEL_C = 1;
    //sql执行类型 update
    const CURD_MODEL_U = 2;
    //sql执行类型 query
    const CURD_MODEL_R = 3;
    //sql执行类型 delete
    const CURD_MODEL_D = 4;

    /**
     * 命名空间
     * @var string
     */
    public $namespace;

    /**
     * 类名(完整类名)
     * @var string
     */
    public $className;

    /**
     * 类名(去掉命名空间的类名)
     * @var string
     */
    public $shortName;

    /**
     * 存放执行的sql和结果，用于调试
     *
     * @var array
     */
    protected static $_sqlArr;

    /**
     * AR constructor.构造方法，设置类名、获取数据库链接
     */
    public function __construct()
    {
        $class = get_called_class();
        $class = new \ReflectionClass($class);
        $this->namespace = $class->getNamespaceName();
        $this->className = $class->getName();
        $this->shortName = $class->getShortName();

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
     * 执行insert update delete sql的方法
     * @param $sql
     * @return bool
     */
    protected function _exec($sql,$model = self::CURD_MODEL_C){
        $result = $this->exec($sql);
        self::$_sqlArr[] = ['sql'=>$sql,'result'=>$result];
        if( $model === self::CURD_MODEL_C ){
            $this->lastInsertId = $this->getLastInsertId();
        }
        return !empty($result);
    }

    /**
     * 获取最后一次插入的id
     * @return string
     */
    public function getLastInsertId(){
        return $this->lastInsertId();
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
     * @return $this
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
     * @return $this
     */
    abstract public function where($condition = []);

    /**
     * 追加的查询条件，可以为数组或字符串
     * @var $this
     */
    protected $addWhere;

    /**
     * 定义追加的查询条件的抽象方法规范
     * @param array $condition
     * @return $this
     */
    abstract public function addWhere($condition = []);

    /**
     * @param array $orderBy
     * @return $this
     */
    abstract public function orderBy($orderBy = []);

    /**
     * @param array $groupBy
     * @return $this
     */
    abstract public function groupBy($groupBy = []);

    /**
     * @param array $condition
     * @return $this
     */
    abstract public function having($condition = []);

    protected $limit;

    /**
     * @param $offset
     * @param $rows
     * @return $this
     */
    abstract public function limit($offset=null,$rows=null);

}