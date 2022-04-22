<?php

/** @var yii\web\View $this */
/** @var frontend\components\bootstrap4\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use \frontend\components\bootstrap4\Html;
use \frontend\components\bootstrap4\ActiveForm;

$this->title = 'Registrarse';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
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
                <div class="form-floating mb-3">
                    <div class="inner-addon right-addon">
                        <?= $form->field($model, 'name')->textInput(['placeholder'=> 'Nombre','autofocus' => true, 'class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                        <img class="icon-form-image" src="/images/icons/user.png">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-floating mb-3">
                    <div class="inner-addon right-addon">
                        <?= $form->field($model, 'lastname')->textInput(['placeholder'=> 'Apellidos', 'class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                        <img class="icon-form-image" src="/images/icons/users.png">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-floating mb-3">
                    <div class="inner-addon right-addon">
                        <?= $form->field($model, 'username')->textInput(['placeholder'=> 'Nombre de Usuario', 'class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                        <img class="icon-form-image" src="/images/icons/bars.png">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-floating mb-3">
                    <div class="inner-addon right-addon">
                        <?= $form->field($model, 'email')->textInput(['placeholder'=> 'Correo electrónico', 'class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                        <img class="icon-form-image" src="/images/icons/envelope.png">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-floating mb-3">
                    <div class="inner-addon right-addon">
                        <?= $form->field($model, 'phone')->textInput(['placeholder'=> 'Teléfono', 'class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                        <img class="icon-form-image" src="/images/icons/phone.png">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-floating mb-3">
                    <div class="inner-addon right-addon">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder'=> 'Contraseña','class' => 'form-control form-control-lg noiconinvalid'])->label(false) ?>
                        <img class="icon-form-image" src="/images/icons/key.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4 mb-5">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-2 buttons-register pe-4 ps-4 pe-lg-none ps-lg-none">
                    <?= Html::submitButton('REGISTRARSE', ['class' => 'btn btn-warning btn-acceder', 'name' => 'signup-button']) ?>
                    <br/>
                    <?= Html::a('CANCELAR',['/site/index'], ['class' => 'btn btn-cancelar mt-3 mb-3', 'name' => 'cancel']) ?>
                </div>
                <div class="col-12 d-block d-md-none  mt-3">
                    <hr class="separador"/>
                </div>
                <div class="col-lg-10 mb-5">
                    <div class="row">
                        <div class="col-lg-4 mt-4">
                            <?= Html::a('<span class="span1">Olvidé mi contraseña</span>',['/site/request-password-reset']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <span class="span2">Ya tiene cuenta?</span>
                            <?= Html::a('<span class="span1">Acceder</span>',['/site/login']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php ActiveForm::end(); ?>
