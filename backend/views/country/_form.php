<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\switchinput\SwitchInput;
use kartik\form\ActiveField;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php

 $form = ActiveForm::begin([
         'options' => ['enctype' => 'multipart/form-data'],
         'fieldConfig' => [
              'showHints' => true,
              'hintType' => ActiveField::HINT_SPECIAL,
         ],
 ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'phone_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?=
            $form->field($model, "sms_price")->widget(NumberControl::classname(), [
                "maskedInputOptions" => [
                    "allowMinus" => false,
                    "groupSeparator" => ".",
                    "radixPoint" => ",",
                    "digits" => 2
                ],
                "displayOptions" => ["class" => "form-control kv-monospace"],
                "saveInputContainer" => ["class" => "kv-saved-cont"]
            ])
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <?=
            $form->field($model,"status")->widget(SwitchInput::classname(), [
                "type" => SwitchInput::CHECKBOX,
                "pluginOptions" => [
                    "onText"=> Yii::t("backend","Activo"),
                    "offText"=> Yii::t("backend","Inactivo")
                ]
            ])
            ?>
        </div>
    </div>


</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> '.Yii::t('backend','Crear') : '<i class="fa fa-pencil"></i> '.Yii::t('yii', 'Update'), ['class' => 'btn btn-default btn-flat']) ?>
    <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'),['index'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>
</div>
<?php ActiveForm::end(); ?>

