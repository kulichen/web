<?php

namespace app\models;

use yii\db\ActiveRecord;

class Images extends ActiveRecord
{
    public static function tableName()
    {
        return 'images';
    }

    public function attributeLabels()
    {
        return[
            'id_images'=>'Image Id',
            'path'=>'Name',
            'caption'=>'Caption'
        ];
    }
    public function rules()
    {
        return [
            [['path', 'caption'],'required']
        ];
    }
}