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
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\settings\Landing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php 
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#sections-main" data-toggle="tab"><?= Yii::t('backend','Secciones') ?></a></li>
            <li><a href="#services-details" data-toggle="tab"><?= Yii::t('backend','Servicios') ?></a></li>
            <li><a href="#socials" data-toggle="tab"><?= Yii::t('backend','Redes Sociales') ?></a></li>
            <li><a href="#privacy-page" data-toggle="tab"><?= Yii::t('backend','Política de privacidad') ?></a></li>
        </ul>
        <div class="tab-content">

            <div class="active tab-pane" id="sections-main">
                <div class="row">
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "welcome_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "about_short_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "about_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "app_short_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "app_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'app_link')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="services-details">
                <div class="row">
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "service_recharge_mobile_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "service_recharge_nauta_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "service_call_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "service_sms_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "service_videocall_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "service_videocall3d_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, "service_2fa_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="socials">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'facebook_url')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'instagram_url')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'linkedin_url')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'twitter_url')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="privacy-page">
                <div class="row">
                    <div class="col-md-12">
                        <?=
                        $form->field($model, "privacy_text")->widget(CKEditor::className(), [
                            "preset" => "custom",
                            "clientOptions" => [
                                "toolbar" => GlobalFunctions::getToolBarForCkEditor(),
                            ],
                        ])
                        ?>
                    </div>
                </div>

            </div>


            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> '.Yii::t('backend','Crear') : '<i class="fa fa-pencil"></i> '.Yii::t('yii', 'Update'), ['class' => 'btn btn-default btn-flat']) ?>
    <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'),['index'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>
</div>
<?php ActiveForm::end(); ?>

