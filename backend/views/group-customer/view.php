<?php

use yii\helpers\Html;
use common\widgets\DetailView;
use mdm\admin\components\Helper;
use common\models\GlobalFunctions;
use common\models\User;
use backend\models\business\CustomerHasGroupCustomer;

/* @var $this yii\web\View */
/* @var $model backend\models\business\GroupCustomer */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grupos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
                [
                    'attribute'=> 'user_id',
                    'value'=> (isset($model->user->name) && !empty($model->user->name))? $model->user->name : null,
                    'format'=> 'html',
                ],
                
                'name',
                'code',
                [
                    'label'=> Yii::t('backend','Clientes'),
                    'value'=> CustomerHasGroupCustomer::getCustomersStringByGroupId($model->id),
                    'format'=> 'html',
                ],
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

                [
                    'attribute'=> 'updated_at',
                    'value'=> GlobalFunctions::formatDateToShowInSystem($model->updated_at),
                    'format'=> 'html',
                ],
                    
    ],
    ]) ?>
</div>
