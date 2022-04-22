<?php
use yii\helpers\Url;
use common\models\User;
use common\models\ConfigServerConstants;

$username = User::findOne(Yii::$app->user->id)->username;
?>

<section class="container-fluid client-area-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-center center-photos mt-5 mb-md-5 mb-2">
                <div class="row hero-service-background mb-0 mb-md-3">
                    <div class="col-12">
                        <img class="hero-image-services" src="/images/our-services.png">
                    </div>
                </div>
                <div class="row mb-5 d-block d-md-none">
                    <div class="col">
                        <img class="cuadros-grises-servicios" src="/images/cuadros-grises-lg.png">
                    </div>
                </div>
            </div>

            <div class="row services-items-group mt-5">
                <div class="col-md-2 col-12 mb-5">
                    <div class="row">
                        <div class="col-md-12 col-2">
                            <img class="icons-services ms-md-0 ms-2" src="/images/service-icon-phone.png">
                        </div>
                        <div class="col-md-12 col-10">
                            <a target="_blank" href="<?= ConfigServerConstants::BASE_URL_BACKEND.''.Url::to(['/site/force-login','username' => $username]) ?>" class="btn btn-warning btn-acceder-services mt-md-3 mt-0">Recarga móvil</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12 mb-5">
                    <div class="row">
                        <div class="col-md-12 col-2">
                            <img class="icons-services" src="/images/service-icon-wify.png">
                        </div>
                        <div class="col-md-12 col-10">
                            <a target="_blank" href="<?= ConfigServerConstants::BASE_URL_BACKEND.''.Url::to(['/site/force-login','username' => $username]) ?>" class="btn btn-warning btn-acceder-services mt-md-3 mt-0">Recarga nauta</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12 mb-5">
                    <div class="row">
                        <div class="col-md-12 col-2">
                            <img class="icons-services" src="/images/service-icon-call.png">
                        </div>
                        <div class="col-md-12 col-10">
                            <a target="_blank" href="<?= ConfigServerConstants::BASE_URL_BACKEND.''.Url::to(['/site/force-login','username' => $username]) ?>" class="btn btn-warning btn-acceder-services mt-md-3 mt-0">Llamada de Voz</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12 mb-5">
                    <div class="row">
                        <div class="col-md-12 col-2">
                            <img class="icons-services" src="/images/service-icon-videocall.png">
                        </div>
                        <div class="col-md-12 col-10">
                            <a target="_blank" href="<?= ConfigServerConstants::BASE_URL_BACKEND.''.Url::to(['/site/force-login','username' => $username]) ?>" class="btn btn-warning btn-acceder-services mt-md-3 mt-0">Video Llamada</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12 mb-5">
                    <div class="row">
                        <div class="col-md-12 col-2">
                            <img class="icons-services" src="/images/service-icon-sms.png">
                        </div>
                        <div class="col-md-12 col-10">
                            <a target="_blank" href="<?= ConfigServerConstants::BASE_URL_BACKEND.''.Url::to(['/site/force-login','username' => $username]) ?>" class="btn btn-warning btn-acceder-services mt-md-3 mt-0">Mensajería SMS</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12 mb-5">
                    <div class="row">
                        <div class="col-md-12 col-2">
                            <img class="icons-services" src="/images/service-icon-2fa.png">
                        </div>
                        <div class="col-md-12 col-10">
                            <a target="_blank" href="<?= ConfigServerConstants::BASE_URL_BACKEND.''.Url::to(['/site/force-login','username' => $username]) ?>" class="btn btn-warning btn-acceder-services mt-md-3 mt-0">2FA/3FA</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 text-center center-photos">
                <div class="row mb-5 d-none d-md-block">
                    <div class="col">
                        <img class="cuadros-grises-servicios" src="/images/cuadros-grises-lg.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

