<?php

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\RechargeEtecsaType */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Oferta de recarga');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Ofertas de recargas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-etecsa-type-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
