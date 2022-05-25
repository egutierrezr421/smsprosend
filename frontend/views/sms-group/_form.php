<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\switchinput\SwitchInput;
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use kartik\number\NumberControl;
use common\models\GlobalFunctions;
use kartik\datecontrol\DateControl;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\business\Customer;
use backend\models\business\GroupCustomer;

/* @var $this yii\web\View */
/* @var $model backend\models\business\SmsGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php 
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <div class="row">
        <div class="col-md-12">
            <?=
            $form->field($model, "group_customer_list")->widget(Select2::classname(), [
                "data" => GroupCustomer::getSelectMap(),
                "language" => Yii::$app->language,
                'maintainOrder' => true,
                "options" => [
                    "placeholder" => "----",
                    "multiple"=>true],
                "pluginOptions" => [
                    "allowClear" => true
                ]
            ])->label('Grupo de contactos');
            ?>
        </div>
        <div class="col-md-12">
            <?=
            $form->field($model, "message")->textarea(['rows' => 4])
            ?>
        </div>
    </div>

</div>
<div class="box-footer">
    <?= Html::submitButton('<i class="fa fa-send"></i> '.Yii::t('backend','Enviar'), ['class' => 'btn btn-primary btn-flat me-3']) ?>
    <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'),['index'], ['class' => 'btn btn-secondary btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>
</div>
<?php ActiveForm::end(); ?>

