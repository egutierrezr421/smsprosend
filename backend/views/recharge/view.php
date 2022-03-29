<?php

use yii\helpers\Html;
use common\widgets\DetailView;
use mdm\admin\components\Helper;
use common\models\GlobalFunctions;
use common\models\User;
use backend\models\nomenclators\PaymentMethod;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Recharge */

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
            'attribute'=> 'user_id',
            'value'=> (isset($model->user_id) && !empty($model->user_id))? User::getFullNameByUserId($model->user_id) : null,
            'format' => 'html',
            'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
        ],
            
        [
            'attribute'=> 'authorized_by',
            'value'=> GlobalFunctions::formatNumber($model->authorized_by),
            'format'=> 'html',
            'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
        ],
            
        [
            'attribute'=> 'payment_method_id',
            'value'=> (isset($model->payment_method_id) && !empty($model->payment_method_id))? $model->paymentMethod->name : null,
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'amount',
            'value'=> GlobalFunctions::formatNumber($model->amount,2),
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'commission',
            'value'=> GlobalFunctions::formatNumber($model->commission,2),
            'format'=> 'html',
            'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
        ],
            
        [
            'attribute'=> 'total_to_pay',
            'value'=> GlobalFunctions::formatNumber($model->total_to_pay,2),
            'format'=> 'html',
        ],
            
        'source_account',

        'target_account',

        [
            'attribute'=> 'paid',
            'value'=> GlobalFunctions::getStatusValue($model->paid,'true','badge bg-gray'),
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'status',
            'value'=> GlobalFunctions::getStatusValue($model->status),
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'rejected_note',
            'value'=> $model->rejected_note,
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
