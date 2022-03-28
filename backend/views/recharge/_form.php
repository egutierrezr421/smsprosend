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
use backend\models\nomenclators\PaymentMethod;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Recharge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php 
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <?=
                    $form->field($model, "payment_method_id")->widget(Select2::classname(), [
                        "data" => PaymentMethod::getSelectMap(),
                        "language" => Yii::$app->language,
                        "options" => ["placeholder" => "----", "multiple"=>false],
                        "pluginOptions" => [
                            "allowClear" => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'source_account')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, "amount")->widget(NumberControl::classname(), [
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
                <div class="col-md-6">
                    <?=
                    $form->field($model, "total_to_pay")->widget(NumberControl::classname(), [
                        "readonly" => true,
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
                <div class="col-md-12">
                    <?= $form->field($model, 'target_account')->textInput(['maxlength' => true,'readonly'=> true]) ?>
                </div>
            </div>

        </div>
        <?php if (GlobalFunctions::getRol() === User::ROLE_SUPERADMIN) : ?>
            <div class="col-md-4">
                <?=
                $form->field($model, "status")->widget(Select2::classname(), [
                    "data" => UtilsConstants::getRechargeStatuses(),
                    "language" => Yii::$app->language,
                    "options" => ["placeholder" => "----", "multiple"=>false],
                    "pluginOptions" => [
                        "allowClear" => true
                    ],
                ]);
                ?>

                <?=
                $form->field($model, "rejected_note")->widget(CKEditor::className(), [
                    "preset" => "custom",
                    "clientOptions" => [
                        "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                    ],
                ])
                ?>
                <?= $form->field($model, 'commission')->hiddenInput()->label(false)->error(false) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> <?= Yii::t('backend','Atención') ?>!</h4>
                <p id="text-description"><?= Yii::t('backend','Confirme si ya fue a su cuenta y realizó el pago, tenga en cuenta que confirmar un pago falso puede ocasionar el bloqueo de su cuenta automáticamente ') ?></p>
            </div>
        </div>
        <div class="col-md-12">
            <?=
            $form->field($model,"paid")->widget(SwitchInput::classname(), [
                "type" => SwitchInput::CHECKBOX,
                "pluginOptions" => [
                    "onText"=> Yii::t("backend","SI"),
                    "offText"=> Yii::t("backend","NO")
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

<?php
$url = \yii\helpers\Url::to(['payment-method/get-payment']);
$js_main = <<<JS
$(document).ready(function(e) {
    
       updateData();
        
		$("#recharge-payment_method_id").change(function() 
		{
		    updateData();
		});
		
		$("#recharge-amount-disp").keyup(function (e) {
		    updateData();
	    });
		
		function updateData() {
		    var method_id = $("#recharge-payment_method_id").val();
		    var amount = $("#recharge-amount-disp").val().replace(/\./g,"");
            amount = amount.replace(",",".");
            amount = parseFloat(amount);
		    
		    if(method_id) {
		        $.ajax({
                    type: 'GET',
                    url: "$url?id="+method_id,
                    success: function(response) {
                        var commission = parseFloat(response.model.commission);
                        var total = amount + (amount*(commission/100));
                        
                        $("#recharge-commission").val(commission);
                        
                        $("#recharge-total_to_pay-disp").val(total);
                        $("#recharge-total_to_pay").val(total);
                        
                        $("#recharge-target_account").val(response.model.target_account);
                        $("#text-description").html(response.model.description);
                    }
	            });
		    }
		}
});
JS;

// Register action buttons js
$this->registerJs($js_main);
?>

