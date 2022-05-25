<?php

use yii\helpers\Html;
use common\widgets\DetailView;
use mdm\admin\components\Helper;
use common\models\GlobalFunctions;
use backend\models\nomenclators\RechargeEtecsaType;
use common\models\User;
use backend\models\business\Customer;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $model backend\models\business\RechargeEtecsa */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Recargas'), 'url' => ['index']];
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
            'attribute'=> 'recharge_etecsa_type_id',
            'value'=> (isset($model->recharge_etecsa_type_id) && !empty($model->recharge_etecsa_type_id))? $model->rechargeEtecsaType->name : null,
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'user_id',
            'value'=> (isset($model->user_id) && !empty($model->user_id))? User::getFullNameByUserId($model->user_id) : null,
            'format' => 'html',
            'visible' => User::isSuperAdmin()
        ],
            
        [
            'attribute'=> 'customer_id',
            'value'=> (isset($model->customer_id) && !empty($model->customer_id))? $model->customer->name : null,
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'operator',
            'value'=> 'Cubacel = Cuba',
            'format'=> 'html',
        ],

        [
            'attribute'=> 'type',
            'value'=> UtilsConstants::getRechargeType($model->type),
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'quantity',
            'value'=> GlobalFunctions::formatNumber($model->quantity),
            'format'=> 'html',
        ],

        [
            'attribute'=> 'total_cost',
            'value'=> GlobalFunctions::formatNumber($model->total_cost,2),
            'format'=> 'html',
        ],
            
        'email',

        'phone',

        [
            'attribute'=> 'status',
            'value'=> UtilsConstants::getStatusRechargeEtecsa($model->status),
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
