<?php
use yii\helpers\Html;
use backend\models\UtilsConstants;

/** @var yii\web\View $this */
/** @var \backend\models\business\Sms $model */

?>

<div class="card mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent border-primary">
        <div class="text-center text-primary">
            <h3 class="card-title"><?= (empty($model->customer_id))? $model->getFullPhoneNumber() : $model->customer->name ?></h3>
            <h6 class="text-muted"><?= (!empty($model->customer_id))? $model->getFullPhoneNumber() : '' ?></h6>
        </div>
    </div>

    <div class="card-body text-primary">
        <p class="card-text"><?= $model->message ?></p>
    </div>
    <div class="card-footer bg-transparent border-primary">
        <div class="text-primary text-end">
            <div class="col">Estado: <?= UtilsConstants::getSmsStatuses($model->status) ?> </div>
        </div>
    </div>
</div>






