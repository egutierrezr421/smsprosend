<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\Sms */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Mensaje');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mensajes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-create">

    <div class="container">
        <div class="center-box w-65">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
