<?php

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\RechargeEtecsaType */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Oferta de recarga').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Ofertas de recargas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="recharge-etecsa-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
