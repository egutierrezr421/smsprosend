<?php
use yii\helpers\Html;
use backend\models\UtilsConstants;

/** @var yii\web\View $this */
/** @var \backend\models\nomenclators\News $model */

?>

<div class="card mb-3">
    <div class="card-header bg-transparent border-primary">
        <div class="text-center text-primary">
            <h3 class="card-title"><?= $model->name ?></h3>
        </div>
    </div>
    <div class="card-body text-primary">
        <?= Html::img(Yii::$app->urlManagerBackend->baseUrl.'/'.$model->getImageUrl(),['class' => 'w-100']) ?>
    </div>
</div>






