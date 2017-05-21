<?php
namespace userModel;
use base\BaseModel;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property string $id
 * @property integer $username
 * @property integer $sex
 * @property string $openid
 * @property string $last_login_longitude
 * @property string $last_login_latitude
 * @property integer $last_login_time
 * @property integer $avatar_url
 * @property integer $create_time
 */
class Users extends BaseModel {

    public static function tableName(){
        return 'bill_users';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'username' => '用户名',
            'sex' => '',
            'openid' => '微信用户id',
            'last_login_longitude' => '最后一次登陆经度',
            'last_login_latitude' => '最后一次登陆维度',
            'last_login_time' => '最后一次登陆时间',
            'create_time' =>  '创建时间',
            'avatar_url' =>  '用户图像',
        ];
    }
}