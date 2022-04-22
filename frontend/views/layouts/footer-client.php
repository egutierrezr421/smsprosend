<?php
/** @var \yii\web\View $this */
/** @var \backend\models\settings\Landing $landing */

?>

<div class="container-fluid bg-black-kubacel pb-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 footer-border-section1">
                <div class="row">
                    <div class="col-12">
                        <img class="image-contact" src="/images/our-contacts.png">
                    </div>
                    <div class="col-12 items-footer-social-icon text-center text-md-left">
                        <?php
                             if(isset($landing->facebook_url) && !empty($landing->facebook_url)) {
                               echo '<a href="'.$landing->facebook_url.'" target="_blank"><img class="social-icon-footer" src="/images/icon-facebook.png"></a>';
                             }

                            if(isset($landing->instagram_url) && !empty($landing->instagram_url)) {
                                echo '<a href="'.$landing->instagram_url.'" target="_blank"><img class="social-icon-footer" src="/images/icon-instagram.png"></a>';
                            }

                            if(isset($landing->linkedin_url) && !empty($landing->linkedin_url)) {
                                echo '<a href="'.$landing->linkedin_url.'" target="_blank"><img class="social-icon-footer" src="/images/icon-linkedin.png"></a>';
                            }

                            if(isset($landing->twitter_url) && !empty($landing->twitter_url)) {
                                echo '<a href="'.$landing->twitter_url.'" target="_blank"><img class="social-icon-footer" src="/images/icon-twitter.png"></a>';
                            }
                        ?>
                    </div>
                    <div class="col-12 mt-4 items-footer-social-icon text-center text-md-left">
                        <a href="<?= \yii\helpers\Url::to(['/site/privacy']) ?>" class="text-decoration-none color-white-kubacel">Política de privacidad</a>
                    </div>
                </div>
            </div>
            <hr class="line">
            <div class="col-1 d-md-block d-none">
                &nbsp;
            </div>
            <div class="col-12 col-md-7">
                <?= $this->render('../site/contact-form', ['result' => null]) ?>
            </div>
        </div>
    </div>
</div>