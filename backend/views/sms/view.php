<?php

use yii\helpers\Html;
use common\widgets\DetailView;
use mdm\admin\components\Helper;
use common\models\GlobalFunctions;
use common\models\User;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $model backend\models\business\Sms */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Mensajes'), 'url' => ['index']];
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
            'attribute'=> 'id_msg',
            'value'=> $model->id_msg,
            'format' => 'html',
            'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
        ],

        [
            'attribute'=> 'user_id',
            'value'=> (isset($model->user_id) && !empty($model->user_id))? User::getFullNameByUserId($model->user_id) : null,
            'format' => 'html',
            'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
        ],
            
        [
            'attribute'=> 'customer_id',
            'value'=> (isset($model->customer_id) && !empty($model->customer_id))? $model->customer->name : 'YO',
            'format'=> 'html',
        ],
            
        [
            'attribute'=> 'receptor_country_id',
            'value'=> (isset($model->receptor_country_id) && !empty($model->receptor_country_id))? '+'.$model->country->phone_code.' - '.$model->country->name : null,
            'format'=> 'html',
        ],
            
        'receptor_phone_number',

        [
            'attribute'=> 'message',
            'value'=> $model->message,
            'format'=> 'html',
            'valueColOptions'=>['style'=>'word-break: break-all;']
        ],

        [
            'attribute'=> 'cost',
            'value'=> GlobalFunctions::formatNumber($model->cost,2),
            'format'=> 'html',
        ],

        [
            'attribute'=> 'status',
            'value'=> $model->getStatusWithTags(),
            'format'=> 'raw',
        ],

        'created_at'
            
    ],
    ]) ?>
</div>
