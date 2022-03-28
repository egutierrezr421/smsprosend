<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\Recharge */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Recarga').': '. $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Recargas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="recharge-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
