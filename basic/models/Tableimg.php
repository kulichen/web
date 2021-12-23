<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tableimg extends ActiveRecord
{
    public static function tableName()
    {
        return 'tableimg';
    }
    public function attributeLabels()
    {
        return[
            'id'=>'Идендификатор изображения',
            'name'=>'Наименование',
            'caption'=>'Описание'
        ];
    }
    public function rules()
    {
        return [
            [['name','caption'],'required']
        ];
    }
}