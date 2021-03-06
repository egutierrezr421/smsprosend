<?php

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\Country */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'País').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Países'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="country-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
