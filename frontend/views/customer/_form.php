<?php

use yii\helpers\Html;
use frontend\components\bootstrap4\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use backend\models\nomenclators\Country;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
    <?php
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-12 mt-2">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-7 mt-2">
            <?=
            $form->field($model, "country_id")->dropDownList(Country::getSelectMap(),['placeholder' => '----']);
            ?>
        </div>
        <div class="col-md-5 mt-2">
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-7 mt-2">
            <?= $form->field($model, 'nauta')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

</div>
<div class="box-footer mt-5 text-center">
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> '.Yii::t('backend','Crear') : '<i class="fa fa-pencil"></i> '.Yii::t('yii', 'Update'), ['class' => 'btn btn-primary btn-flat me-3']) ?>
    <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'),['index'], ['class' => 'btn btn-secondary btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>
</div>
<?php ActiveForm::end(); ?>

