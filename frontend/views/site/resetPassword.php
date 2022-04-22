<?php

/** @var yii\web\View $this */
/** @var \frontend\components\bootstrap4\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use frontend\components\bootstrap4\Html;
use frontend\components\bootstrap4\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

<section class="container-fluid bg-blue-kubacel" style="height: 100%">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-4">
                <img class="logo-authenticate" src="/images/logo-white.png">
            </div>
        </div>
        <div class="row">
            <div class="img-list-logo">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <h4 class="text-white mb-5"><?= Yii::t('backend','Por favor, elija su nueva contraseña') ?></h4>
            <div class="col-12 col-lg-6">
                <div class="form-floating mb-3">
                    <div class="inner-addon right-addon">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder'=> 'Nueva contraseña', 'class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                        <img class="icon-form-image" src="/images/icons/key.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-2 pe-4 ps-4 pe-lg-none ps-lg-none">
                    <?= Html::submitButton('ENVIAR', ['class' => 'btn btn-warning btn-acceder', 'name' => 'send-button']) ?>

                    <?= Html::a('CANCELAR',['/site/index'], ['class' => 'btn btn-cancelar mt-3 mb-3', 'name' => 'cancel']) ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php ActiveForm::end(); ?>
