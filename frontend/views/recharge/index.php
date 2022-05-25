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

<p>
    <?= Html::a(Yii::t('frontend', 'Fondear'), ['create'], ['class' => 'btn btn-primary']) ?>
</p>


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

