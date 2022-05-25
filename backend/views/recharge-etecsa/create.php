<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\RechargeEtecsa */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Recarga Etecsa');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Recargas Etecsa'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-etecsa-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
