<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\business\GroupCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Mis grupos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <p>
        <?= Html::a(Yii::t('frontend', 'Crear grupo'), ['create'], ['class' => 'btn btn-primary']) ?>
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


</div>
