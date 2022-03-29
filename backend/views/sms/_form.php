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
use backend\models\nomenclators\Country;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Sms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php 
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-4">

                    <?=
                    $form->field($model, "customer_id")->widget(Select2::classname(), [
                        "data" => Customer::getSelectMap(),
                        "language" => Yii::$app->language,
                        "options" => ["placeholder" => "Yo", "multiple"=>false],
                        "pluginOptions" => [
                            "allowClear" => true
                        ],
                    ]);
                    ?>


                    <?=
                    $form->field($model, "receptor_country_id")->widget(Select2::classname(), [
                        "data" => Country::getSelectMap(),
                        "language" => Yii::$app->language,
                        "options" => ["placeholder" => "----", "multiple"=>false],
                        "pluginOptions" => [
                            "allowClear" => true
                        ],
                    ]);
                    ?>

                    <?= $form->field($model, 'receptor_phone_number')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, "message")->textarea(['rows' => 4])
            ?>
            <div style="float: right;" class="help-block help-block-error"><span id="counter">0</span>/150 caracteres</div>
        </div>
    </div>

</div>
<div class="box-footer">
    <?= Html::submitButton('<i class="fa fa-send"></i> '.Yii::t('backend','Enviar'), ['class' => 'btn btn-default btn-flat']) ?>
    <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'),['index'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$url = \yii\helpers\Url::to(['payment-method/get-payment']);
$js_main = <<<JS
$(document).ready(function(e) {
    
       updateData();
        	       
		$("#sms-message").keyup(function (e) {
		    updateData();
	    });
		
		function updateData() {
		    var method_id = $("#sms-message").val();
		    var countCharacter = method_id.length;
		    
		    $("#counter").html(countCharacter);
		    
		}
});
JS;

// Register action buttons js
$this->registerJs($js_main);
?>

