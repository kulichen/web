<?php 

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'SingUp';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-singup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to singup:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'singup-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= HTML::submitButton('SingUp', ['class' => 'btn btn-success']); ?>
                <?= HTML::a('Back', ['login'], ['class' => 'btn btn-primary']); ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
