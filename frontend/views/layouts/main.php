<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use backend\models\settings\Landing;
use frontend\widgets\Custom_Alert;
use kartik\dialog\Dialog;

AppAsset::register($this);

$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
$landing = Landing::find()->one();
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>


<?= Dialog::widget() ?>
<?= Custom_Alert::widget() ?>

<?php if($action_id == 'login' || $action_id == 'signup' || $action_id == 'request-password-reset' || $action_id == 'reset-password') { ?>
    <?= $content ?>
<?php } elseif ($action_id == 'client-area' || $action_id == 'confirm-signup' || $action_id == 'info-reset-password') { ?>
    <?= $this->render('header-client', ['content' => $content]) ?>
    <main class="min-vh-100">
        <?= $content ?>
    </main>
    <?= $this->render('sections/news-client', ['landing' => $landing]) ?>
    <?= $this->render('footer-client', ['landing' => $landing]) ?>

<?php } elseif ($action_id == 'client-new-message' || $action_id == 'client-offers' || $action_id == 'client-my-contacts' || $action_id == 'client-statistic' || $controller_id == 'customer' || $controller_id == 'recharge' || $controller_id == 'sms' || $controller_id == 'sms-group' || $controller_id == 'news' || $controller_id == 'recharge-etecsa'  || $controller_id == 'group-customer' || $action_id == 'profile' || $action_id == 'change-password') { ?>
    <?= $this->render('header-client', ['content' => $content]) ?>
    <div class="container-fluid ps-4">
        <div class="row">
            <?= $this->render('sidebar-client', ['content' => $content, 'action_id' => $action_id, 'controller_id' => $controller_id]) ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-2 min-vh-100">
                <header>
                    <div class="row">
                        <div class="col-md-8 text-center">
                            <h1 class="title-page-client"><?= $this->title ?></h1>
                        </div>
                        <div class="col-md-4 mb-3">
                            <img class="w-100" src="/images/content-client.png">
                            <i class="subtitle-balance-label">Fondos disponibles</i> <i class="balance-label">$ <?= \backend\models\business\Recharge::getAvailableBalance() ?></i>
                        </div>
                    </div>
                </header>
                <?= $content ?>
            </main>
        </div>
    </div>

    <?= $this->render('sections/news-client', ['landing' => $landing]) ?>
    <?= $this->render('footer-client', ['landing' => $landing]) ?>

<?php } else { ?>

    <?= $this->render('header', ['content' => $content]) ?>

    <div class="bg-gray-kubacel">
    <?php
    if ($action_id == 'page-service' || $action_id == 'privacy' || $action_id == 'about' || $action_id == 'app-page')
    {
        echo $content;
    }
    else {
        echo $this->render('sections/hero', ['landing' => $landing]);
        echo $this->render('sections/carrusel', ['landing' => $landing]);
        echo $this->render('sections/our-services', ['landing' => $landing]);
        echo $this->render('sections/about', ['landing' => $landing]);
        echo $this->render('sections/our-app', ['landing' => $landing]);
    }
    ?>
    </div>

    <?= $this->render('footer', ['landing' => $landing]) ?>

<?php } ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
