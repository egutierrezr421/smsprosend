<?php

use kartik\file\FileInput;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="row">
        <div class="col-md-5 mb-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-7 mb-3">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-3">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-7 mb-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-7 mb-3">
            <?= $form->field($model, 'url_to_notify_delivery')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <?php

    if($model->isNewRecord)
	    $urlAvatar = Yii::$app->urlManagerBackend->baseUrl.'/'.User::getUrlAvatarByUserID();
    else
        $urlAvatar = Yii::$app->urlManagerBackend->baseUrl.'/'.User::getUrlAvatarByUserID($model->id);
    ?>
    <div class="row">
        <div class="col-md-5 mb-3">
            <?= $form->field($model, 'fileAvatar')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions'=> [
                'theme' => 'fas',
                'removeClass' => 'btn btn-danger',
                'showPreview' => true,
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'defaultPreviewContent'=> '<img src="'.$urlAvatar.'" class="previewAvatar">',
                ]
            ]);
            ?>
        </div>
    </div>




