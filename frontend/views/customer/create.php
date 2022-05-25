<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Customer */

$this->title = Yii::t('frontend', 'Crear contacto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
        <div class="center-box">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
</div>
