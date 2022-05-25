<?php
use yii\helpers\Html;
use backend\models\business\CustomerHasGroupCustomer;

/** @var yii\web\View $this */
/** @var \backend\models\business\GroupCustomer $model */

?>

<div class="card mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent border-primary">
        <div class="text-end">
            <?= Html::a('<i class="fas fa-edit"></i>',['update','id' => $model->id],['class' => 'btn btn-primary me-2']) ?>

            <?= Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-danger btn-confirm' ]) ?>

        </div>
    </div>

    <div class="card-body text-primary">
        <h4 class="card-title border-bottom border-primary pb-3"><?= $model->name ?></h4>

        <p class="card-text">
            <?= CustomerHasGroupCustomer::getCustomersStringByGroupId($model->id) ?>
        </p>

    </div>
</div>


<?php
$url = \yii\helpers\Url::to(['group-customer/delete','id'=>$model->id]);
$label = "¿Seguro desea eliminar este grupo?";
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



