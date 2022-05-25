<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\business\Customer;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\business\SmsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accordion mb-4" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="fas fa-search me-3"> </i> Buscar
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="customer-search">

                    <?php $form = ActiveForm::begin([
                        'action' => ['history-sms'],
                        'method' => 'get',
                    ]); ?>

                    <div class="row">
                        <div class="col">
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
                        <div class="col">
                            <?= $form->field($model, 'receptor_phone_number') ?>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <?= Html::submitButton(Yii::t('frontend', 'Buscar'), ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('frontend', 'Limpiar'),['/sms/history-sms'], ['class' => 'btn btn-outline-secondary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

