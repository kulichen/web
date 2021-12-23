<?php
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;
?>
	
<?php if($model->path): 
    //echo $model->path;
    //echo $model->caption;
 endif; ?>  

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?= $form->field($model, 'path')->fileInput() ?>
<?= $form->field($model, 'caption')->textInput() ?>
<div class="form-group">
    <?= HTML::submitButton('Save', ['class' => 'btn btn-success']) ?>
    <?= HTML::a("Back", ['gallery'], ['class'=>'btn btn-primary']); ?>
</div>
<?php ActiveForm::end() ?>