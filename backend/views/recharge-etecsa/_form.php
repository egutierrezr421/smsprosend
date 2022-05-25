<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use backend\models\nomenclators\RechargeEtecsaType;
use common\models\User;
use backend\models\business\Customer;
use backend\models\business\RechargeEtecsa;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $model backend\models\business\RechargeEtecsa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php 
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, "recharge_etecsa_type_id")->widget(Select2::classname(), [
                "data" => RechargeEtecsaType::getSelectMap(),
                "language" => Yii::$app->language,
                "options" => ["placeholder" => "----", "multiple"=>false],
                "pluginOptions" => [
                    "allowClear" => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, "operator")->widget(Select2::classname(), [
                "data" => [1=>'Cubacel = Cuba'],
                "language" => Yii::$app->language,
                "options" => ["placeholder" => "----", "multiple"=>false],
                "pluginOptions" => [
                    "allowClear" => true
                ],
            ]);
            ?>
        </div>

        <div class="col-md-3">
            <?=
            $form->field($model, "type")->widget(Select2::classname(), [
                "data" => UtilsConstants::getRechargeType(),
                "language" => Yii::$app->language,
                "options" => ["placeholder" => "----", "multiple"=>false],
                "pluginOptions" => [
                    "allowClear" => true
                ],
            ]);
            ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-2">
            <?=
            $form->field($model, "quantity")->widget(NumberControl::classname(), [
                "maskedInputOptions" => [
                    "allowMinus" => false,
                    "groupSeparator" => ".",
                    "radixPoint" => ",",
                    "digits" => 0
                ],
                "displayOptions" => ["class" => "form-control kv-monospace"],
                "saveInputContainer" => ["class" => "kv-saved-cont"]
            ])
            ?>
        </div>

        <div class="col-md-2">
            <?=
            $form->field($model, "total_cost")->widget(NumberControl::classname(), [
                'readonly' => true,
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

        <div class="col-md-3">
            <?=
            $form->field($model, "customer_id")->widget(Select2::classname(), [
                "data" => Customer::getSelectMap(),
                "language" => Yii::$app->language,
                "options" => ["placeholder" => "----", "multiple"=>false],
                "pluginOptions" => [
                    "allowClear" => true
                ],
            ]);
            ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <?=
            $form->field($model, "user_id")->widget(Select2::classname(), [
                "data" => User::getSelectMap(),
                "language" => Yii::$app->language,
                "options" => ["placeholder" => "----", "multiple"=>false],
                "pluginOptions" => [
                    "allowClear" => true
                ],
            ]);
            ?>
        </div>

        <div class="col-md-3">
            <?=
            $form->field($model, "status")->widget(Select2::classname(), [
                "data" => UtilsConstants::getStatusRechargeEtecsa(),
                "language" => Yii::$app->language,
                "options" => ["placeholder" => "----", "multiple"=>false],
                "pluginOptions" => [
                    "allowClear" => true
                ],
            ]);
            ?>
        </div>
    </div>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> '.Yii::t('backend','Crear') : '<i class="fa fa-pencil"></i> '.Yii::t('yii', 'Update'), ['class' => 'btn btn-default btn-flat']) ?>
    <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'),['index'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$url = \yii\helpers\Url::to(['customer/get-customer']);
$url_2 = \yii\helpers\Url::to(['recharge-etecsa-type/get-data']);
$js_main = <<<JS
$(document).ready(function(e) {
    
       updateData();
       loadCustomerData();
        	       
		$("#rechargeetecsa-quantity-disp").keyup(function (e) {
		    updateData();
	    });		
		
		$("#rechargeetecsa-recharge_etecsa_type_id").change(function (e) {
		    updateData();
	    });
		
        $("#rechargeetecsa-customer_id").change(function() 
		{
		    loadCustomerData();
		});
        		
		function updateData() {
		    
            var recharge_etecsa_type_id = $("#rechargeetecsa-recharge_etecsa_type_id").val();
		    if(recharge_etecsa_type_id) {
            $.ajax({
                type: 'GET',
                url: "$url_2?id="+recharge_etecsa_type_id,
                success: function(response) {
                    var cost = response.model.cost;
                    if(cost) {
                       cost = parseFloat(cost);
                       var quantity = $("#rechargeetecsa-quantity-disp").val();
                       
                       if(quantity) {
                           quantity = parseInt(quantity);
                       } else {
                           quantity = 1;
                           $("#rechargeetecsa-quantity-disp").val(1);
                           $("#rechargeetecsa-quantity").val(1);
                       }
                       
                       var totalCost = quantity * cost;
                       
                       $("#rechargeetecsa-total_cost-disp").val(totalCost);
                       $("#rechargeetecsa-total_cost").val(totalCost);
                    }
                 
                }
            });
            }
		    
		    var quantity = $("#rechargeetecsa-quantity-disp").val();
            quantity = parseInt(quantity);
            
            
		}
		
		function loadCustomerData() {
		    var customer_id = $("#rechargeetecsa-customer_id").val();
		    if(customer_id) {
            $.ajax({
                type: 'GET',
                url: "$url?id="+customer_id,
                success: function(response) {
                    var nauta = response.model.nauta;
                    var phone = response.full_phone;
                                        
                    if(nauta) {
                       $("#rechargeetecsa-email").val(nauta);
                    } else {
                        $("#rechargeetecsa-email").val(null);
                    }
                    
                     if(phone) {
                       $("#rechargeetecsa-phone").val(phone);
                    }
                }
            });
            } else {
		        $("#rechargeetecsa-phone").val(null);
		        $("#rechargeetecsa-email").val(null);
            }
		    
		}
});
JS;

// Register action buttons js
$this->registerJs($js_main);
?>