<?php
/**
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/5/21
 * Time: 18:12
 * Class Common
 * @package base
 */
namespace base;
class Common  {
    /**
     * curl获取资源
     * @param $url
     * @param array $data
     * @return string
     */
    public static function curl_post($url,$data=array()){
        $ch = curl_init() ;
        curl_setopt($ch, CURLOPT_URL,$url) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        ob_start();
        curl_exec($ch);
        $result = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch) ;
        return $result;
    }

    /**
     * get方式获取网页内容
     * @param $url
     * @return mixed
     */
    public static function curl_get($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}