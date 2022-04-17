<?php

/* @var $this yii\web\View */
/* @var $model backend\models\settings\Landing */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Landing').': '. $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Landings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="landing-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
