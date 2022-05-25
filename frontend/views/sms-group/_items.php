<?php

use backend\models\business\GroupCustomerHasSmsGroup;

/** @var yii\web\View $this */
/** @var \backend\models\business\Recharge $model */

?>

<div class="card mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent border-primary">
        <div class="text-primary">
            <h6 class="text-muted"><b>Grupos: </b><?= GroupCustomerHasSmsGroup::getGroupCustomersStringBySmsGroupId($model->id) ?></h6>
        </div>
    </div>

    <div class="card-body text-primary">
        <p class="card-text"><b>Mensaje: </b><?= $model->message ?></p>
    </div>
</div>






