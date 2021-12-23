<?php

namespace app\models;

use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }
    public function attributeLabels()
    {
        return [
            'id_user' => 'ID User',
            'username' => 'Login',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'acess_token' => 'Acess Token',
        ];
    }
    public function rules()
    {
        return [
            [['username','password'], 'required']
        ];
    }
}