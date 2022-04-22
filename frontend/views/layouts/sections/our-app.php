<?php
/**
 * Created by PhpStorm.
 * User: Nety
 * Date: 12/04/2022
 * Time: 2:27 PM
 */

use yii\helpers\Url;

/** @var \backend\models\settings\Landing $landing */
?>



<!-- Section about -->
<section id="app-section" class="container mb-5">
    <img class="green-separator-left" src="/images/green-separator.png">
    <img class="our-app-image" src="/images/know-app.png">
    <div class="row w-100">
        <div class="col-12 col-md-6">
            <img class="w-100" src="/images/image-app.png">
        </div>
        <div class="col-12 col-md-6 text-md-start text-end">
            <p>
                <?= $landing->app_short_text ?>
            </p>
            <p><a class="text-decoration-none" href="<?= Url::to(['/site/app-page']) ?>">Saber más >></a></p>
            <br>
            <p class="color-black-kubacel">¿Ya tienes nuestra App?</p>
            <p><a href="<?= $landing->app_link ?>" target="_blank" class="btn btn-warning">Descargar App</a></p>
        </div>
    </div>
</section>
<!-- Section about -->
