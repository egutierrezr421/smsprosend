<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\SmsGroup */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Mensaje publicitario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mensajes publicitarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-group-create">

    <div class="center-box w-65">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
