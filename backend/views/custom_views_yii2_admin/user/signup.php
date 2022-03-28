<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\settings\Setting;
use common\models\GlobalFunctions;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('backend', 'Registrarse');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$fieldOptionsMail = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon- form-control-feedback'></span>"
];
?>

<div class="login-box" style="margin: 1% auto !important;">
    <div class="login-logo adjust_logo_image">
        <img src="<?= Setting::getUrlLogoBySettingAndType(1,1) ?>" alt="" style="max-width: 200px; max-height: 200px">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= Yii::t('backend','Rellene con sus datos para registrarse') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'signup-form', 'enableClientValidation' => false]); ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form
                    ->field($model, 'name', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => "{input}<span class='fa fa-user form-control-feedback'></span>"
                    ])
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('name')])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form
                    ->field($model, 'lastname', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => "{input}<span class='fa fa-users form-control-feedback'></span>"
                    ])
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('lastname')])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form
                    ->field($model, 'username', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => "{input}<span class='fa fa-key form-control-feedback'></span>"
                    ])
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('username')])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form
                    ->field($model, 'email', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => "{input}<span class='fa fa-envelope form-control-feedback'></span>"
                    ])
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('email')])
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= $form
                    ->field($model, 'phone', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => "{input}<span class='fa fa-phone form-control-feedback'></span>"
                    ])
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('phone')])
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= $form
                    ->field($model, 'password', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => "{input}<span class='fa fa-lock form-control-feedback'></span>"
                    ])
                    ->label(false)
                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= Html::submitButton(Yii::t('backend','Registrarse'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <div class="col-md-6">
                <?= Html::a(Yii::t('backend','Cancelar'),['site/index'], ['class' => 'btn btn-default btn-block btn-flat', 'name' => 'cancel-button']) ?>
            </div>
            <!-- /.col -->
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <?= Html::a(Yii::t('backend','Olvidé mi contraseña'),['/security/user/request-password-reset']) ?>
            </div>
            <div class="col-md-12">
                <?= Yii::t('backend','¿Ya tienes cuenta?').' '.Html::a(Yii::t("backend","Acceder"), ['/security/user/login']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
