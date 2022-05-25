<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\UtilsConstants;

/** @var yii\web\View $this */
/** @var \backend\models\business\RechargeEtecsa $model */

$status = (int) $model->status;
?>

<div class="card mb-3" style="max-width: 18rem;">
    <?php if($status === UtilsConstants::RECHARGE_ETECSA_STATUS_PENDING) : ?>
    <div class="card-header bg-transparent border-primary">
        <div class="text-end">
            <?= Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-danger btn-confirm' ]) ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="card-body text-primary">
        <h5 class="card-title border-bottom border-primary pb-3"><?= $model->quantity.'x '.$model->rechargeEtecsaType->name ?></h5>
        <p class="card-text"><i class="fas fa-phone"></i> <?= $model->phone ?></p>
        <?php if(isset($model->email) && !empty($model->email)): ?>
            <p class="card-text"><i class="fas fa-at"></i> <?= $model->email ?> </p>
        <?php endif; ?>
    </div>
    <div class="card-footer bg-transparent border-primary">
        <div class="text-primary text-end">
            <div class="col">Estado: <?= UtilsConstants::getStatusRechargeEtecsa($model->status) ?> </div>
        </div>
    </div>
</div>


<?php
$url = Url::to(['recharge-etecsa/delete', 'id'=>$model->id]);
$label = "¿Seguro desea eliminar este elemento?";
$js = <<< JS

$(".btn-confirm").on("click", function() {
    krajeeDialog.confirm("$label", function (result) {
        if (result) {
            $.ajax({
                type: 'POST',
                url: "$url",
            });
        }
    });
});
JS;

// register your javascript
$this->registerJs($js);
?>






