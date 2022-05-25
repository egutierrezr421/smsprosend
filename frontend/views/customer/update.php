<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Customer */

$this->title = Yii::t('frontend', 'Actualizar contacto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Update');
?>
<div class="customer-update">

    <div class="container">
        <div class="center-box">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
