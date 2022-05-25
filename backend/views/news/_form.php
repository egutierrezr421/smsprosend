<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use kartik\switchinput\SwitchInput;
use dosamigos\ckeditor\CKEditor;
use common\models\GlobalFunctions;
use kartik\select2\Select2;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
<?php 
 $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?=
            $form->field($model, "type")->widget(Select2::classname(), [
                "data" => UtilsConstants::getNewsType(),
                "language" => Yii::$app->language,
                "options" => ["placeholder" => "----", "multiple" => false],
                "pluginOptions" => [
                    "allowClear" => true
                ],
            ]);
            ?>

            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

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
        <div class="col-md-4">
            <?=
            $form->field($model, "image")->widget(FileInput::classname(), [
                "language" => Yii::$app->language,
                "pluginOptions" => GlobalFunctions::getConfigFileInputWithPreview($model->getImageFile(), $model->id),
            ]);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, "description")->widget(CKEditor::className(), [
                "preset" => "custom",
                "clientOptions" => [
                    "toolbar" => GlobalFunctions::getToolBarForCkEditor(true),
                ],
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

