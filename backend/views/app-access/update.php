<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\AppAccess */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Integración API').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Integración API'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="app-access-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
