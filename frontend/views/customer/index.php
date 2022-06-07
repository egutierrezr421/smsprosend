<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\business\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Contactos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <p>
        <?= Html::a(Yii::t('frontend', 'Crear contacto'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php
        echo $this->render('_search', ['model' => $searchModel]);
    ?>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'options' => ['class' => 'container row'],
        'itemOptions' => ['class' => 'col-md-4 col-12 mb-4'],
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


</div>
