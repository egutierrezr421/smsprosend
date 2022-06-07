<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use backend\models\business\Customer;
use backend\models\nomenclators\Country;
use backend\models\UtilsConstants;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Sms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <?=
                $form->field($model, "customer_id")->widget(Select2::classname(), [
                    "data" => Customer::getSelectMap(),
                    "language" => Yii::$app->language,
                    "options" => ["placeholder" => "----", "multiple"=>false],
                    "pluginOptions" => [
                        "allowClear" => true
                    ],
                ])->label('Contacto');
            ?>
        </div>
        <div class="col-md-6">
            <?=
                $form->field($model, "type")->widget(Select2::classname(), [
                    "data" => UtilsConstants::getSmsType(),
                    "language" => Yii::$app->language
                ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
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
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'receptor_phone_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <?=
            $form->field($model, "message")->textarea(['rows' => 4])
            ?>
            <div style="float: right;" class="help-block"><span id="counter">0</span>/150 caracteres - <span id="counter-sms">1</span> sms</div>
        </div>

        <div id="hidden-date" class="col-md-6" style="display: none;">

            <?= $form->field($model, 'programmer_date')->widget(DateControl::classname(), [
                "type" => DateControl::FORMAT_DATETIME
            ])
            ?>
        </div>

    </div>

</div>
<div class="box-footer text-center mt-5 mb-5">
    <?= Html::submitButton('<i class="fa fa-send"></i> '.Yii::t('backend','Enviar'), ['class' => 'btn btn-primary btn-flat me-3']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$url = \yii\helpers\Url::to(['customer/get-customer']);
$js_main = <<<JS
$(document).ready(function(e) {
    
       updateData();
       loadCustomerData();
       checkHidden();
        	       
		$("#sms-message").keyup(function (e) {
		    updateData();
	    });
		
        $("#sms-customer_id").change(function() 
		{
		    loadCustomerData();
		});
        
        $("#sms-type").change(function() 
		{
		    checkHidden();
		});
		
		function updateData() {
		    var method_id = $("#sms-message").val();
		    var countCharacter = method_id.length;
		    
		    var countSms = Math.ceil(countCharacter/150);
		    		    
		    $("#counter").html(countCharacter);
		    $("#counter-sms").html(countSms);
		}
		
		function loadCustomerData() {
		    var customer_id = $("#sms-customer_id").val();
		    if(customer_id) {
            $.ajax({
                type: 'GET',
                url: "$url?id="+customer_id,
                success: function(response) {
                    var country_id = response.model.country_id;
                    var phone = response.model.phone_number;
                                        
                    $("#sms-receptor_country_id").val(country_id).trigger("change");
                    $("#sms-receptor_phone_number").val(phone);
                }
            });
		    }
		}
		
		function checkHidden() {
		    var type = $("#sms-type").val();
		    if(type == 2) {
		        document.getElementById('hidden-date').style.display = 'block';
		    } else {
		        document.getElementById('hidden-date').style.display = 'none';
		    }
		}
});
JS;

// Register action buttons js
$this->registerJs($js_main);
?>

