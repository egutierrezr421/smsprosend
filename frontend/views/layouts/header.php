<?php
use yii\helpers\Url;
?>
<header class="header navbar navbar-expand-lg navbar-light bg-light navbar-sticky navbar-stuck">
    <div class="container px-0 px-xl-3">
        <a class="ms-2 me-2 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <img class="d-block d-md-none d-lg-none d-xl-none d-xxl-none img-menu" src="/images/menu.png">
        </a>
        <a class="navbar-brand flex-shrink-0 order-lg-1 mx-auto ms-lg-0 pe-lg-2 me-lg-4" href="<?= Yii::$app->getHomeUrl() ?>">
            <img class="header-logo" src="/images/main-logo.png" alt="Logo">
        </a>
        <div class="d-flex align-items-center order-lg-3">
            <a class="btn d-lg-inline-block d-none" href="#modal-contact" data-bs-toggle="modal">
                <img class="icon-login" src="/images/icon-login.png">
            </a>
            <a class="btn btn-sm d-lg-none d-inline-block" href="#modal-contact" data-bs-toggle="modal">
                <img class="icon-login" src="/images/icon-login.png">
            </a>
        </div>
        <div class="collapse navbar-collapse order-lg-2 m-2 items-header-nav" id="navbarCollapse">
            <a href="<?= Url::to(['/#services-section']) ?>" class="nav-item nav-link color-black-kubacel">Servicios</a>
            <a href="<?= Url::to(['/#about-section']) ?>" class="nav-item nav-link color-black-kubacel">Nosotros</a>
            <a href="<?= Url::to(['/#offers-section']) ?>" class="nav-item nav-link color-black-kubacel">Ofertas</a>
            <a href="<?= Url::to(['/#app-section']) ?>" class="nav-item nav-link color-black-kubacel">App</a>
        </div>
    </div>
</header>