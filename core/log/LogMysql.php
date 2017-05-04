<?php
/**
 * 将日志文件存储在mysql中
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/4/10
 * Time: 23:10
 */
namespace core\log;

class LogMysql implements Log{
    public function log($fileName, $content = '', $array = []){
        dump($fileName, $content, $array,'mysql');die;
        // TODO: Implement log() method.
    }
}
