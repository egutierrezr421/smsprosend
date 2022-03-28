<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\SmsGroup */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Mensaje grupal').': '. $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mensajes grupales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="sms-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
