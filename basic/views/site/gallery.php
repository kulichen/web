<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\Images;
use yii\widgets\LinkPager;

$this->title = 'Gallery';
?>
<div>
    <h1>Gallery</h1>

    <hr>

    <!-- <?php if (Yii::$app->session->hasFlash('success')) :
        echo Yii::$app->session->getFlash('success');
        endif; 
    ?>

    <?php if (Yii::$app->session->hasFlash('error')) :
        echo Yii::$app->session->getFlash('error'); 
        endif; 
    ?> -->

    <div class="grid">
        <?php
        foreach ($models as $newimage) {
            echo '<figure class="gallery">';
            echo Html::img($newimage->path, ['class' => 'gallery']);
            echo "<figcaption>$newimage->path</figcaption>";
            echo "<figcaption>$newimage->caption</figcaption>";
            // echo HTML::submitButton("Save", ['class' => 'btn btn-success']);
            echo Html::a('Edit', ['/site/editimage', 'id_images' => $newimage->id_images], ['role' => 'button', 'class' => 'btn btn-success']);
            echo "</figure>";
        }
        ?>
    </div>

    <hr>

    <nav>
        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </nav>
</div>