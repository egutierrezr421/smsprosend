<?php
use yii\helpers\Url;
?>
<header class="header navbar navbar-expand-lg navbar-light bg-blue-kubacel navbar-sticky navbar-stuck">
    <div class="container">
        <a class="ms-2 me-2 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <img class="d-block d-md-none d-lg-none d-xl-none d-xxl-none img-menu" src="/images/menu.svg">
        </a>
        <a class="navbar-brand flex-shrink-0 order-lg-1 mx-auto ms-lg-0 pe-lg-2 me-lg-4" href="<?= Yii::$app->getHomeUrl() ?>">
            <img class="header-logo" src="/images/main-logo-white.png" alt="Logo">
        </a>
        <?php if(!Yii::$app->user->isGuest) : ?>
        <div class="order-lg-3">
            <a class="mr-5" href="<?= Url::to(['/site/logout']) ?>">
                <i class="fas fa-sign-out-alt fa-2x text-white"></i>
            </a>
        </div>
        <?php endif; ?>
        <div class="collapse navbar-collapse order-lg-2 m-2 items-header-nav" id="navbarCollapse">

        </div>
    </div>
</header>