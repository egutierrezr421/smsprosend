<?php

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\PaymentMethod */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Método de pago');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Métodos de pago'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
