<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \backend\models\business\Sms $model */

?>

<div class="card mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent border-primary">
        <div class="text-end mb-3">
            <?= Html::button('<i class="fas fa-trash"></i>', ['value' => \yii\helpers\Url::to(['delete', 'id' => $model->id]), 'class' => 'btn btn-danger btn-confirm' ]) ?>
        </div>
        <div class="text-center text-primary">
            <h3 class="card-title"><?= (empty($model->customer_id))? $model->getFullPhoneNumber() : $model->customer->name ?></h3>
            <h6 class="text-muted"><?= (!empty($model->customer_id))? $model->getFullPhoneNumber() : '' ?></h6>
        </div>
    </div>

    <div class="card-body text-primary">
        <p class="card-text"><?= $model->message ?></p>
    </div>
    <div class="card-footer bg-transparent border-primary">
        <div class="text-primary">
            <?php if(!empty($model->programmer_date)): ?>
            <div class="col"><i class="fas fa-clock"> </i> <?= date('d-M-Y h:i A', strtotime($model->programmer_date)) ?> </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php
$url = \yii\helpers\Url::to(['sms/delete','id'=>$model->id]);
$label = "¿Seguro desea eliminar este mensaje?";
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



