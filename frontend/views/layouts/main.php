<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use backend\models\settings\Landing;

AppAsset::register($this);

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

<?= $this->render('header', ['content' => $content]) ?>

<div class="bg-gray-kubacel">
<?php

$action_id = Yii::$app->controller->action->id;

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
    echo $content;
}
?>


</div>

<?= $this->render('footer', ['landing' => $landing]) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
