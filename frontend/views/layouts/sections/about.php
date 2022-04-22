<?php

use yii\helpers\Url;

/** @var \backend\models\settings\Landing $landing */
?>

<!-- Section about -->
<section id="about-section" class="container">
    <img class="about-label-image" src="/images/about-us.png">
    <div class="row">
        <div class="col-12 col-md-6 order-2 order-md-1 pr-2">
            <p>
                <?= $landing->about_short_text ?>
            </p>
            <a class="text-decoration-none" href="<?= Url::to(['/site/about']) ?>">Saber más >></a>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-2">
           <img class="about-image" src="/images/image-about.png">
        </div>
    </div>
</section>
<!-- Section about -->
