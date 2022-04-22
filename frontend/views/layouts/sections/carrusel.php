<?php
/**
 * Created by PhpStorm.
 * User: Nety
 * Date: 12/04/2022
 * Time: 2:27 PM
 */

use backend\models\settings\Carrousel;
?>

<div class="blue-separator">
</div>
<!-- Section Carrusel -->
<section id="offers-section" class="container-fluid bg-blue-kubacel">
    <div class="container">
        <div class="row mb-5 carrusel-top-background">
            <div class="col-6 col-md-4">
                <img class="offer-image" src="/images/ofertas.png">
            </div>
            <div class="col-6 col-md-8">
            </div>
        </div>

        <div id="myCarousel" class="carousel slide pointer-event pb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <?php
                    $all_images = Carrousel::findAll(['status' => 1]);
                    if(count($all_images) === 0) {
                        echo '<div class="carousel-item">
                                <img class="w-100" src="/images/carrusel1.png">
                            </div>';
                    }
                    else {
                        foreach ($all_images AS $key => $value) {
                            $active = ($key === 0)? 'active' : '';
                            $url_image = Yii::$app->urlManagerBackend->baseUrl.'/'.$value->getImageUrl();
                            echo '<div class="carousel-item '.$active.'">
                                <img class="w-100 img-carrusel" src="'.$url_image.'">
                            </div>';
                        }
                    }
                ?>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
<!-- Section Carrusel -->
