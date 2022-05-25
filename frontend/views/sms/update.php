<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\Sms */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Mensaje').': '. $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mensajes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="sms-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
