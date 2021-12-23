<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\models\Images;
?>

<h2>Delete image</h2>


<?php
$form = ActiveForm::begin(['layout' => 'horizontal']); 
?>
<div class="form-group">
    <?= HTML::submitButton('Delete', ['class' => 'btn btn-success']);?>
    <?= Html::a('Back', ['/site/editimage', 'id_images' => $id_images], ['role' => 'button', 'class'=>'btn btn-primary']); ?>
</div>

<?php
ActiveForm::end();
?>

<hr>

<?php
echo "<figcaption><b>Name:</b> $model->path</figcaption>";
echo "<figcaption><b>Caption:</b> $model->caption</figcaption>";   
?>

<hr>

<div class="grid">
    <figure class="editimage">
        <?php
        $newimage = Images::findOne($id_images);
        echo Html::img($newimage->path, ['class' => 'editimage']);
        //echo "<figcaption>$newimage->path</figcaption>";
        //echo "<figcaption>$newimage->caption</figcaption>";
        ?>
    </figure>
</div>