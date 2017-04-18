<?php
/**
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 17-2-11
 * Time: 下午11:02
 */
return $config = [
    'db' => require_once "db.php",
    'default_router' => [
        'controller' => 'test',
        'action' => 'test'
    ],
    /**
     * 日志配置
     * type => ['File'=>[ 'path' => 'log/runtime'],'Mysql']
     */
    'log' => [
        'type' =>'File',
        'path' => 'log/runtime',
    ]
];