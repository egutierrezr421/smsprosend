<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var string $title */
/** @var string $top_separator_url */
/** @var string $bottom_separator_url */
/** @var string $content_image_url */
/** @var string $content_image_url_right */
/** @var string $text */
/** @var string $btn_label */

$this->title = $title;
?>

<!-- Section page-service -->
<section id="page-service" class="page-section mt-5 mb-5 pt-5 pb-5">
    <img class="top-separator-page" src="<?= $top_separator_url ?>">
    <div class="row w-100">
        <div class="col-12 col-md-4 text-md-start text-center">
            <img class="content-image" src="<?= $content_image_url ?>">

            <?= $text ?>

            <a href="<?= Url::to(['/site/login']) ?>" class="btn btn-warning mt-1 mt-md-5 mb-1 mb-md-5"><?= $btn_label ?></a>
        </div>
        <div class="col-1 d-md-block d-none">
            &nbsp;
        </div>
        <div class="col-12 col-md-7">
            <img class="w-100" src="<?= $content_image_url_right ?>">
        </div>
    </div>
    <img class="bottom-separator-page" src="<?= $bottom_separator_url ?>">
</section>
<!-- Section page-service -->