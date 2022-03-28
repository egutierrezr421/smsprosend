<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\Customer */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Cliente');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Clientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
