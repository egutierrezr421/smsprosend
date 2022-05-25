<?php
use yii\helpers\Html;
use backend\models\UtilsConstants;

/** @var yii\web\View $this */
/** @var \backend\models\business\Recharge $model */

?>

<div class="card mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent border-primary">
        <div class="text-center text-primary">
            <h3 class="card-title">$<?= $model->amount ?></h3>

        </div>
    </div>

    <div class="card-body text-primary">
        <p class="card-text"><?= 'Forma de pago: '.$model->paymentMethod->name ?></p>
        <p class="card-text"><?= $model->getAttributeLabel('total_to_pay').': $'.$model->total_to_pay ?></p>
    </div>
    <div class="card-footer bg-transparent border-primary">
        <div class="text-primary text-end">
            <div class="col">Estado: <?= UtilsConstants::getRechargeStatuses($model->status) ?> </div>
        </div>
    </div>
</div>






