<?php

use backend\models\nomenclators\News;
?>

<div class="blue-separator">
</div>
<!-- Section News -->
<section id="offers-section" class="container-fluid bg-blue-kubacel">
    <div class="container pt-4 pb-4">
        <div class="row">
            <div class="col-md-3 col-12 background-white-wave me-5">
                <img class="w-100 mt-5" src="/images/news-today.png">
            </div>
            <div class="col-md-8 col-12 ms-md-5 ms-0 mt-5">
                <div id="myCarousel" class="carousel slide pointer-event pb-5" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
                        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <?php
                        $all_news = News::findAll(['status' => 1,'type'=>\backend\models\UtilsConstants::NEWS_TYPE_NEWS]);

                        foreach ($all_news AS $key => $value) {
                            $active = ($key === 0)? 'active' : '';
                            echo '<div class="carousel-item '.$active.'">
                            <div class="card-simple mb-3">
                                <div class="card-header bg-transparent border-primary">
                                    <div class="text-center text-primary">
                                        <h3 class="card-title">'.$value->name.'</h3>
                                    </div>
                                </div>
                                <div class="card-body text-primary">
                                    '.$value->description.'
                                </div>
                            </div>
                        </div>';
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
        </div>

    </div>
</section>
<!-- Section News -->
