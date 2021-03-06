<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use backend\models\settings\Setting;
use common\models\GlobalFunctions;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model \backend\models\settings\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'token_qvatel')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?=
                $form->field($model,"office_status")->widget(SwitchInput::classname(), [
                    "type" => SwitchInput::CHECKBOX,
                    "pluginOptions" => [
                        "onText"=> Yii::t("backend","Online"),
                        "offText"=> Yii::t("backend","Offline")
                    ]
                ])
                ?>
            </div>
        </div>


	    <?php

	    if($model->isNewRecord)
        {
            $url_main_logo = Setting::getUrlLogoBySettingAndType(1);
            $url_header_logo = Setting::getUrlLogoBySettingAndType(2);
            $url_mini_header_logo = Setting::getUrlLogoBySettingAndType(3);
        }
	    else
        {
            $url_main_logo = Setting::getUrlLogoBySettingAndType(1, $model->id);
            $url_header_logo = Setting::getUrlLogoBySettingAndType(2, $model->id);
            $url_mini_header_logo = Setting::getUrlLogoBySettingAndType(3,$model->id);
        }

	    ?>
        <div class="row">
            <div class="col-md-4">
			    <?= $form->field($model, 'file_main_logo')->widget(FileInput::classname(), [
				    'options' => ['accept' => 'image/*'],
				    'pluginOptions'=> [
					    'browseIcon'=>'<i class="fa fa-camera"></i> ',
					    'browseLabel'=> Yii::t('backend','Cambiar'),
					    'allowedFileExtensions'=>['jpg','jpeg','gif','png'],
					    'defaultPreviewContent'=> '<img src="'.$url_main_logo.'" class="previewAvatar">',
					    'showUpload'=> false,
					    'layoutTemplates'=> [
						    'main1'=>  '{preview}<div class=\'input-group {class}\'><div class=\'input-group-btn\'>{browse}{upload}{remove}</div>{caption}</div>',
					    ],
				    ]
			    ]);
			    ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'file_header_logo')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions'=> [
                        'browseIcon'=>'<i class="fa fa-camera"></i> ',
                        'browseLabel'=> Yii::t('backend','Cambiar'),
                        'allowedFileExtensions'=>['jpg','jpeg','gif','png'],
                        'defaultPreviewContent'=> '<img src="'.$url_header_logo.'" class="previewAvatar">',
                        'showUpload'=> false,
                        'layoutTemplates'=> [
                            'main1'=>  '{preview}<div class=\'input-group {class}\'><div class=\'input-group-btn\'>{browse}{upload}{remove}</div>{caption}</div>',
                        ],
                    ]
                ]);
                ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'file_mini_header_logo')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions'=> [
                        'browseIcon'=>'<i class="fa fa-camera"></i> ',
                        'browseLabel'=> Yii::t('backend','Cambiar'),
                        'allowedFileExtensions'=>['jpg','jpeg','gif','png'],
                        'defaultPreviewContent'=> '<img src="'.$url_mini_header_logo.'" class="previewAvatar">',
                        'showUpload'=> false,
                        'layoutTemplates'=> [
                            'main1'=>  '{preview}<div class=\'input-group {class}\'><div class=\'input-group-btn\'>{browse}{upload}{remove}</div>{caption}</div>',
                        ],
                    ]
                ]);
                ?>
            </div>

        </div>

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> '.Yii::t('backend','Crear') : '<i class="fa fa-pencil"></i> '.Yii::t('yii', 'Update'), ['class' => 'btn btn-default btn-flat']) ?>

    </div>
    <?php ActiveForm::end(); ?>

