<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Images;
use yii\widgets\ActiveForm;

$this->title = 'Edit';
?>
<div>
    <h1>Edit image</h1>

    <?php 
    if (Yii::$app->session->hasFlash('success')) :
        echo Yii::$app->session->getFlash('success');
        endif; 
    ?>

    <?php
    if (Yii::$app->session->hasFlash('error')) :
        echo Yii::$app->session->getFlash('error');
        endif; 
    ?>

    <?php
    echo Html::a('Delete image', ['/site/deleteimage', 'id_images' => $id_images], ['role' => 'button', 'class'=>'btn btn-primary']);
    //echo Html::a("Delete image", ['class'=>'btn btn-primary', 'id_images' => $id_images]);
    ?>

    <hr>

    <div class="grid">
        <figure class="editimage">
            <?php
            $newimage = Images::findOne($id_images);
            echo Html::img($newimage->path, ['class' => 'editimage']);
            echo "<figcaption>$newimage->path</figcaption>";
            //echo "<figcaption>$newimage->caption</figcaption>";
            echo 111;
            ?>
        </figure>
    </div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'caption')->textInput() ?>
    <?= HTML::submitButton("Save", ['class' => 'btn btn-success']); ?>
    <?= HTML::submitButton("Back", ['class'=>'btn btn-primary', 'name' => 'back']); ?>
    <?php ActiveForm::end() ?>
</div>