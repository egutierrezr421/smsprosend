<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\business\SmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = Yii::t('backend', 'Mensajes');
$this->params['breadcrumbs'][] = $this->title;

?>

<p class="container">
    <?= Html::a(Yii::t('frontend', 'Nuevo mensaje'), ['send-sms'], ['class' => 'btn btn-primary me-3']) ?>
    <?= Html::a(Yii::t('frontend', 'Chequear estados'), ['check-status'], ['class' => 'btn btn-secondary']) ?>
</p>

<?php
echo $this->render('_search', ['model' => $searchModel]);
?>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'options' => ['class' => 'container row'],
    'itemOptions' => ['class' => 'col-md-3 col-12 mb-4'],
    'summaryOptions' => ['class' => 'mb-4'],
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_items', ['model' => $model]);
    },
]) ?>

