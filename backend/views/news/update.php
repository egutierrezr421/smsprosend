<?php

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\News */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'News').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="news-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
