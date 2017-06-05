<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/6/5
 * Time: 18:32
 */
namespace core;
class Render extends Object{
    public static function display($layout,$path,$value){
        extract($value);
        //layout 输出
        //path 输出
    }
}