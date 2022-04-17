<?php

/** @var \backend\models\settings\Landing $landing */
?>

<!-- Page app -->
<section class="container mt-5 mb-5 pt-5 pb-5">
    <img class="about-label-image" src="/images/know-app.png">
    <div class="row">
        <div class="col-12 col-md-6 order-2 order-md-1 pr-2">
            <p>
                <?= $landing->app_text ?>
            </p>

            <br>

            <p><a href="<?= $landing->app_link ?>" target="_blank" class="btn btn-warning">Descargar App</a></p>
        </div>
        <div class="col-12 col-md-6 order-1 order-md-2">
           <img class="about-image" src="/images/image-app.png">
        </div>

    </div>
</section>
<!-- Page app -->
