<?php
use backend\models\business\Sms;
use backend\models\business\RechargeEtecsa;
use backend\models\UtilsConstants;

/** @var yii\web\View $this */

$this->title = 'Estadísticas de tu cuenta';
?>

<section>

<div class="row container d-flex mt-0 mt-md-5">

    <div class="col-md-3 col-12 mb-3 text-center">
        <!-- small box -->
        <h6>Mensajes programados</h6>
        <div class="small-box bg-blue-kubacel text-center p-3">
            <h3 class="color-white-kubacel"><?= Sms::find()->where(['status' => \backend\models\UtilsConstants::SMS_STATUS_PROGRAMED])->count() ?></h3>
        </div>
    </div>
    <div class="col-md-3 col-12 mb-3 text-center">
        <!-- small box -->
        <h6>Mensajes enviados</h6>
        <div class="small-box bg-blue-kubacel text-center p-3">
            <h3 class="color-white-kubacel"><?= Sms::getTotalSms() ?></h3>
        </div>
    </div>
    <div class="col-md-3 col-12 mb-3 text-center">
        <!-- small box -->
        <h6>Mensajes publicitarios enviados</h6>
        <div class="small-box bg-blue-kubacel text-center p-3">
            <h3 class="color-white-kubacel"><?= Sms::getTotalSmsGroup() ?></h3>
        </div>
    </div>
    <div class="col-md-3 col-12 mb-3 text-center">
        <!-- small box -->
        <h6>Recargas completadas</h6>
        <div class="small-box bg-blue-kubacel text-center p-3">
            <h3 class="color-white-kubacel"><?= RechargeEtecsa::find()->where(['status' => UtilsConstants::RECHARGE_ETECSA_STATUS_COMPLETE])->count() ?></h3>
        </div>
    </div>
</div>
</section>



