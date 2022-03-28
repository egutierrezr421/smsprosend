<?php

use yii\helpers\Html;
use common\widgets\DetailView;
use mdm\admin\components\Helper;
use common\models\GlobalFunctions;
use common\models\User;
use backend\models\UtilsConstants;


/* @var $this yii\web\View */
/* @var $model backend\models\business\Customer */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Clientes'), 'url' => ['index']];
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
                    'format'=> 'html',
                    'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
                ],
                
                [
                    'attribute'=> 'country_id',
                    'value'=> (isset($model->country->name) && !empty($model->country->name))? $model->country->name : null,
                    'format'=> 'html',
                ],
                
                'name',

                [
                    'attribute'=> 'phone_number',
                    'value'=> '+'.$model->country->phone_code.''.$model->phone_number,
                    'format'=> 'html',
                ],

                [
                    'attribute'=> 'token',
                    'value'=> $model->token.' '.'<button class="btn btn-flat btn-xs btn-primary copy_btn" value="'.$model->token.'" data-toggle="tooltip" data-original-title="Copiar" data-copied-title="Copiado"><i class="fa fa-clone"></i></button>',
                    'format'=> 'raw',
                ],

                [
                    'attribute'=> 'allow_send_sms',
                    'value'=> GlobalFunctions::getStatusValue($model->send_sms_type,true,'badge bg-gray'),
                    'format'=> 'html',
                ],

                [
                    'attribute'=> 'send_sms_type',
                    'value'=> UtilsConstants::getCustomerSmsAccessType($model->send_sms_type),
                    'format'=> 'html',
                ],

                'max_sms',

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
