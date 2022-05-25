<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \backend\models\business\Customer $model */

?>

<div class="card mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent border-primary">
        <div class="text-end">
            <?= Html::a('<i class="fas fa-edit"></i>',['update','id' => $model->id],['class' => 'btn btn-primary me-2']) ?>

            <?= Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-danger btn-confirm' ]) ?>

        </div>
    </div>

    <div class="card-body text-primary">
        <h5 class="card-title border-bottom border-primary pb-3"><?= $model->name ?></h5>
        <p class="card-text"><i class="fas fa-phone"></i> <?= '+'.$model->country->phone_code.' '.$model->phone_number ?></p>
        <?php if(isset($model->nauta) && !empty($model->nauta)): ?>
        <p class="card-text"><i class="fas fa-at"></i> <?= $model->nauta ?> </p>
        <?php endif; ?>
    </div>
    <div class="card-footer bg-transparent border-primary">
        <div class="row d-flex">
            <div class="col"><?= Html::a('Enviar mensaje',['sms/send-sms','customer_id' => $model->id]) ?></div>
            <div class="col"><?= Html::a('Recarga nauta',['recharge-etecsa/new-recharge','customer_id' => $model->id]) ?></div>
        </div>
    </div>
</div>


<?php
$url = \yii\helpers\Url::to(['customer/delete','id'=>$model->id]);
$label = "¿Seguro desea eliminar este contacto?";
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



