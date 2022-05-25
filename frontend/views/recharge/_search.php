<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\business\RechargeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recharge-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'authorized_by') ?>

    <?= $form->field($model, 'payment_method_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'commission') ?>

    <?php // echo $form->field($model, 'total_to_pay') ?>

    <?php // echo $form->field($model, 'source_account') ?>

    <?php // echo $form->field($model, 'target_account') ?>

    <?php // echo $form->field($model, 'paid') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'rejected_note') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Resetear'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
