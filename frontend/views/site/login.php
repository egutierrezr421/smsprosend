<?php

/** @var yii\web\View $this */
/** @var \frontend\components\bootstrap4\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use \frontend\components\bootstrap4\Html;
use \frontend\components\bootstrap4\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
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
            <div class="col-12 col-lg-6">
                <div class="inner-addon right-addon">
                    <?= $form->field($model, 'username')->textInput(['placeholder'=> 'Nombre de Usuario','autofocus' => true, 'class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                    <img class="icon-form-image" src="/images/icons/user.png">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="inner-addon right-addon">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=> 'Contraseña','class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                    <img class="icon-form-image" src="/images/icons/key.png">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-lg-3 col-md-4 mt-3">
                <button class="btn btn-warning btn-lg btn-acceder">ACCEDER</button>
            </div>
        </div>
        <div class="row">
            <div class=" col-12 col-lg-6  mt-3">
                <hr class="separador"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12 mt-3">
                <?= Html::a('<span class="span1">Olvidé mi contraseña</span>', ['/site/request-password-reset']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 mt-3 mb-5">
                <span class="span2">¿No tiene una cuenta?</span> <?= Html::a('<span class="span1">Registrarse</span>', ['/site/signup']) ?>
            </div>
        </div>
    </div>
</section>
<?php ActiveForm::end(); ?>
