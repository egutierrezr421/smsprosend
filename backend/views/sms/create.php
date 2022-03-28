<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\Sms */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Mensaje');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mensajes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
