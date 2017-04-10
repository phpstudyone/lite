<?php
/**
 * 以文件的方式存储日志
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/4/10
 * Time: 22:21
 */
namespace core\log;
use core\Object;

class LogFile implements Log{
    public function log($fileName, $content = '', $array = []){
        dump($fileName, $content, $array);die;
        // TODO: Implement log() method.

    }
}
