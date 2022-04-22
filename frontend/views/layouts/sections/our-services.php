<?php

use yii\helpers\Url;

?>

<div class="blue-separator-left"></div>
<!-- Section Our Services -->
<section id="services-section" class="container-fluid orange-separator-right mb-5">
    <div class="row row-services">
        <div class="col-12 mb-5">
            <img class="our-services-image" src="/images/our-services.png">
        </div>
        <div class="col-6 col-md-3 mb-4">
            <a class="text-decoration-none" href="<?= Url::to(['/site/page-service','type' => 1]) ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title title-kubacel-services">Recarga móvil</h5>
                        <img class="service-image" src="/images/service-icon-phone.png">
                    </div>
                </div>
            </a>

        </div>
        <div class="col-6 col-md-3 mb-4">
            <a class="text-decoration-none" href="<?= Url::to(['/site/page-service','type' => 2]) ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title title-kubacel-services">Recarga nauta</h5>
                        <img class="service-image" src="/images/service-icon-wify.png">
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3 mb-4">
            <a class="text-decoration-none" href="<?= Url::to(['/site/page-service','type' => 3]) ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title title-kubacel-services">Llamadas</h5>
                        <img class="service-image" src="/images/service-icon-call.png">
                    </div>
                </div>
            </a>
        </div>

        <div class="d-none d-md-block col-6 col-md-3 mb-4">
            &nbsp;
        </div>

        <div class="col-6 col-md-3 mb-4">
            <a class="text-decoration-none" href="<?= Url::to(['/site/page-service','type' => 4]) ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title title-kubacel-services">Mensajes</h5>
                        <img class="service-image" src="/images/service-icon-sms.png">
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3 mb-4">
            <a class="text-decoration-none" href="<?= Url::to(['/site/page-service','type' => 5]) ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title title-kubacel-services">Videollamadas</h5>
                        <img class="service-image" src="/images/service-icon-videocall.png">
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3 mb-4">
            <a class="text-decoration-none" href="<?= Url::to(['/site/page-service','type' => 6]) ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title title-kubacel-services">Videollamadas 3D</h5>
                        <img class="service-image" src="/images/service-icon-videocall3d.png">
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a class="text-decoration-none" href="<?= Url::to(['/site/page-service','type' => 7]) ?>">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title title-kubacel-services">Servicios 2FA</h5>
                        <img class="service-image" src="/images/service-icon-2fa.png">
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
<!-- Section Our Services -->
