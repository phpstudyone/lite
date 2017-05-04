<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/2/16
 * Time: 18:36
 */
namespace core;

use core\AR\AR;

class Object{

    /**
     * 获取配置组件
     * @var object
     */
    public $config;

    /**
     * ar组件
     * @var object
     */
    public $ar;

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
     * Object constructor.
     */
    public function __construct()
    {
        $class = get_called_class();
        $class = new \ReflectionClass($class);
        $this->namespace = $class->getNamespaceName();
        $this->className = $class->getName();
        $this->shortName = $class->getShortName();
        $this->config = Config::getConfig();
        $this->ar = new AR();
    }

    /**
     * 公共的记录日志方法，日志存储方式由配置文件决定
     * @param $fileName
     * @param string $content
     * @param array $array
     * @return mixed
     */
    public function log($fileName, $content = '', $array = []){
        $logConfig = Config::getConfig('log');
        $logObj = "\\core\\log\\Log" . $logConfig['type'];
        return (new $logObj)->log($fileName, $content, $array);
    }
}