<?php

use yii\helpers\Html;
use common\widgets\DetailView;
use mdm\admin\components\Helper;
use common\models\GlobalFunctions;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\News */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GlobalFunctions::showModalHtmlContent(Yii::t('backend','Imagen')) ?>

<div class="box-header">
    <?php
    if (Helper::checkRoute($controllerId . 'update')) {
        echo Html::a('<i class="fa fa-pencil"></i> '.Yii::t('yii','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-flat margin']);
    }

    echo Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'), ['index'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend','Cancelar')]);

    if (Helper::checkRoute($controllerId . 'delete')) {
        echo Html::a('<i class="fa fa-trash"></i> '.Yii::t('yii','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat margin',
            'data' => [
                'confirm' => Yii::t('yii','Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]);
    }
    ?>
</div>
<div class="box-body">
    <?= DetailView::widget([
    'model' => $model,
    'labelColOptions' => ['style' => 'width: 40%'],
    'attributes' => [

        'id',

        'name',

        [
            'attribute'=> 'image',
            'value'=> '<a href="#"><img class="img-responsive img-bordered modalImage" src="'. $model->getPreview().'"></a>',
            'format'=> 'raw',
        ],

        [
            'attribute'=> 'description',
            'format'=> 'html',
        ],

        [
            'attribute'=> 'type',
            'value'=> UtilsConstants::getNewsType($model->type),
            'format'=> 'html',
        ],
            
        'link',

        [
            'attribute'=> 'status',
            'value'=> GlobalFunctions::getStatusValue($model->status),
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'created_at',
            'value'=> GlobalFunctions::formatDateToShowInSystem($model->created_at),
            'format'=> 'html',
        ],
            
    ],
    ]) ?>
</div>
