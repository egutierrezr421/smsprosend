<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\business\RechargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = Yii::t('backend', 'Mensajes publicitarios');
$this->params['breadcrumbs'][] = $this->title;

?>

<p>
    <?= Html::a(Yii::t('frontend', 'Nuevo mensaje'), ['create'], ['class' => 'btn btn-primary']) ?>
</p>


<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'options' => ['class' => 'container row'],
    'itemOptions' => ['class' => 'col-md-6 col-12 mb-4'],
    'summaryOptions' => ['class' => 'mb-4'],
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_items', ['model' => $model]);
    },
    'pager' => [
        'maxButtonCount' => 3,
        'options' => ['class' => 'pagination justify-content-center'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link']
    ],
]) ?>

