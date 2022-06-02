<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\business\RechargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = Yii::t('backend', 'Fondear mi cuenta');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="text-center mt-4 mb-5">
    <h2>
        <?= Html::a('<i class="fas fa-dollar-sign"></i> '.Yii::t('frontend', 'Fondear'), ['create'], ['class' => 'bg-blue-kubacel color-white-kubacel rounded-2 ps-3 pe-3 pt-2 pb-2']) ?>
    </h2>
</div>



<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'options' => ['class' => 'container row'],
    'itemOptions' => ['class' => 'col-md-4 col-12 mb-4'],
    'summaryOptions' => ['class' => 'mb-4'],
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_items', ['model' => $model]);
    },
]) ?>

