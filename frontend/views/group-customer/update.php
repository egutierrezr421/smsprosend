<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\GroupCustomer */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Grupo').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grupos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="group-customer-update">

    <div class="container">
        <div class="center-box w-65">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
