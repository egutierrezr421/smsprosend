<?php

/** @var \backend\models\settings\Landing $landing */

use backend\models\nomenclators\Country;
use backend\models\nomenclators\Service;
use yii\helpers\Url;
?>

<!-- Section Hero -->
<section class="container">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-md-8 text-center text-lg-start">
            <div class="row hero-background">
                <div class="col-12">
                    <img class="hero-image" src="<?= Yii::$app->assetManager->getPublishedUrl('@web') ?>/images/bienvenido-hero.png">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <p class="text-hero">
                        <?= $landing->welcome_text ?>
                    </p>
                    <a href="<?= Url::to(['/site/login']) ?>" class="btn btn-warning">Recarga ya</a>
                </div>
                <div class="d-none d-md-block col-1">
                    &nbsp;
                </div>
                <div class="col-12 col-md-3">
                   <img src="/images/cuadros-grises.png" class="hero-squares">
                </div>
            </div>
        </div>
        <div class="col-md-4 mx-auto">
            <form id="form-calculator" class="needs-validation p-4 border text-center form-calculator">
                <h3 class="fw-bold mb-4">Calculadora</h3>

                <div class="form-floating mb-3">
                    <select id="select-service" class="form-select" aria-label="Servicio" required>
                        <option value="">Servicio</option>
                        <?php
                        $servicess = Service::getSelectMap(true);
                        foreach ($servicess AS $service_id => $service_name) {
                            echo '<option value="'.$service_id.'">'.$service_name.'</option>';
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Seleccione un servicio.</div>
                </div>
                <div class="form-floating mb-3">
                    <select id="select-country" class="form-select" aria-label="País" required>
                        <option value="">País</option>
                        <?php
                            $countries = Country::getSelectReduced();
                            foreach ($countries AS $country_id => $country_name) {
                                echo '<option value="'.$country_id.'">'.$country_name.'</option>';
                            }
                        ?>
                    </select>
                    <div class="invalid-feedback">Seleccione un país.</div>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="quantityInput" placeholder="Cantidad" required>
                    <label for="quantityInput">Cantidad</label>
                    <div class="invalid-feedback">
                        Por favor entre una cantidad.
                    </div>
                </div>

                <button id="btn-calculate" class="w-100 btn btn-lg btn-primary" type="button">Calcular</button>

               <div id="resultCalculate" class="d-none gap-3 color-orange-kubacel fw-bold mt-4">
                   <span id="label-counter-text">10 llamadas</span>
                   <span> ......................... </span>
                   <span id="label-price">$ 2.50</span>
               </div>
            </form>
        </div>
    </div>
</section>
<!-- Section Hero -->

<?php


$js_main = <<<JS
$(document).ready(function(e) {
            
    $("#btn-calculate").click(function (e) {
        e.preventDefault();
		recalculate();
	});
    
    function recalculate() {
       var form = document.getElementById('form-calculator');
       var service = $("#select-service").val();
       var service_text = $("#select-service").find('option:selected').text();
       var country = $("#select-country").val();
       var quantity = $("#quantityInput").val();
       
       if(service && country && quantity) {
           $.ajax({
                type: 'GET',
                cache: false,
                url: '/site/calculate?country_id='+country+'&service_id='+service+'&quantity='+quantity,
                success: function (response) {
                    if(response.success) {
                         $('#resultCalculate').removeClass('d-none');
                         $('#label-counter-text').html(quantity+' '+service_text);
                         $('#label-price').html('$ '+response.price);
                    }
                }
                });
           
       } else {
           $('#resultCalculate').addClass('d-none');
           form.classList.add('was-validated');
       }
    }
});
JS;

$this->registerJs($js_main);
?>
