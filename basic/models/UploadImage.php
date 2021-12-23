<?php
 
namespace app\models;
 
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Images;
use yii\db\ActiveRecord;
 
class UploadImage extends Model 
{
    public $path;
    public $caption;

    public function rules()
    {
        return [
            [['path'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
            [['caption'],'required']
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            if (Images::find()->where(['path' => "downloads/" . $this->path->baseName . '.' . $this->path->extension])->exists()) {    
                Yii::$app->session->setFlash('error', 'Картинка с таким именем уже загружена!');
                return false;
            } 

            $this->path->saveAs('downloads/' . $this->path->baseName . '.' . $this->path->extension);

            $newimage = new Images();
            $newimage->path = "downloads/" . $this->path->baseName . '.' . $this->path->extension;
            $newimage->caption = $this->caption;

            if( $newimage->save() ){
                Yii::$app->session->setFlash('success', 'Данные приняты');
            }else{
                Yii::$app->session->setFlash('error', 'Не сохранена!');
            }

            return true;
        } else {
            Yii::$app->session->setFlash('error', 'Не проходит валидацию!');
            return false;
        }
    }
 
    // public function attributeLabels()
    // {
    //     return[
    //         'path'=>'Наименование',
    //         'caption'=>'Описание'
    //     ];
    // }
    // public function rules()
    // {
    //     return [
    //         [['path'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
    //         [['path', 'caption'], 'safe']

    //     ];
    // } 
}