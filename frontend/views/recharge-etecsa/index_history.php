<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\business\RechargeEtecsaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = Yii::t('backend', 'Historial de recargas');
$this->params['breadcrumbs'][] = $this->title;

?>

<p class="container">
    <?= Html::a(Yii::t('frontend', 'Nueva recarga'), ['new-recharge'], ['class' => 'btn btn-primary me-3']) ?>
</p>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'options' => ['class' => 'container row'],
    'itemOptions' => ['class' => 'col-12 mb-4'],
    'summaryOptions' => ['class' => 'mb-4'],
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_items', ['model' => $model]);
    },
]) ?>

