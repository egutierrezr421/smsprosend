<?php

/** @var yii\web\View $this */
/** @var string $information */

$this->title = Yii::t('frontend','Política de privacidad');
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Section privacy -->
<section id="privacy" class="container mb-5 pt-5 pb-5">
    <div class="row">
        <div class="col-12">
            <?= $information ?>
        </div>
    </div>

</section>
<!-- Section privacy -->
<br>

