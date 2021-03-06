<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\models\User;
use kartik\switchinput\SwitchInput;
use common\models\GlobalFunctions;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

	<?php $form = ActiveForm::begin(); ?>

    <div class="box-body">

        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3">
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-md-3">
                        <?= $form->field($model, 'role')->widget(Select2::classname(), [
                            'data' => GlobalFunctions::getRolesList(),
                            'language' => Yii::$app->language,
                            'options' => [
                                'placeholder' => Yii::t('backend','Seleccione un rol').' ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) ?>
                    </div>

                    <?php if (GlobalFunctions::getRol($model->id) !== User::ROLE_SUPERADMIN): ?>
                        <div class="col-md-2">
                            <?=
                            $form->field($model, "balance")->widget(NumberControl::classname(), [
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
                    <?php endif; ?>

                    <div class="col-md-3">
                        <?php
                        if(Yii::$app->user->can('change-status-users'))
                        {
                            echo $form->field($model, 'switch_status')->widget(SwitchInput::classname(), [
                                'pluginOptions' => [
                                    'onText'=> Yii::t("backend","Activo"),
                                    'offText'=> Yii::t("backend","Inactivo")
                                ]
                            ]);
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <?php

                if($model->isNewRecord)
                    $urlAvatar = User::getUrlAvatarByUserID();
                else
                    $urlAvatar = User::getUrlAvatarByUserID($model->id);
                ?>

                <?= $form->field($model, 'fileAvatar')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions'=> [
                        //'browseIcon'=>'<i class="fa fa-camera"></i> ',
                        //'allowedFileExtensions'=>['jpg','gif','png'],
                        'defaultPreviewContent'=> '<img src="'.$urlAvatar.'" class="previewAvatar">',
                        'showUpload'=> false,
                        'layoutTemplates'=> [
                            'main1'=>  '{preview}<div class=\'input-group {class}\'><div class=\'input-group-btn\'>{browse}{upload}{remove}</div>{caption}</div>',
                        ],
                    ]
                ]);
                ?>

            </div>
        </div>

    <br>

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> '.Yii::t('rbac-admin','Create') : '<i class="fa fa-pencil"></i> '.Yii::t('yii', 'Update'), ['class' => 'btn btn-default btn-flat']) ?>
        <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'), ['index'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>
    </div>
	<?php ActiveForm::end(); ?>

