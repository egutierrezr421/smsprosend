<?php

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\Country */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'País');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Países'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
