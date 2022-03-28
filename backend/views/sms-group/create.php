<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\SmsGroup */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Mensaje grupal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mensajes grupales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-group-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
