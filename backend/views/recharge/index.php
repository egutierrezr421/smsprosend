<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;
use yii\web\View;
use yii\helpers\Url;
use backend\components\Footer_Bulk_Delete;
use backend\components\Custom_Settings_Column_GridView;
use common\models\GlobalFunctions;
use yii\helpers\BaseStringHelper;
use common\models\User;
use backend\models\nomenclators\PaymentMethod;
use backend\models\business\Recharge;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\business\RechargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = Yii::t('backend', 'Recargas');
$this->params['breadcrumbs'][] = $this->title;

$create_button='';
?>

<?php 
	if (Helper::checkRoute($controllerId . 'create')) {
		$create_button = Html::a('<i class="fa fa-plus"></i> '.Yii::t('backend', 'Crear'), ['create'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend', 'Crear').' '.Yii::t('backend', 'Recarga')]);
	}

	$custom_elements_gridview = new Custom_Settings_Column_GridView($create_button,$dataProvider);
?>

    <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'id'=>'grid',
            'dataProvider' => $dataProvider,
            'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'options' => [
                    'enablePushState' => false,
                    'scrollTo' => false,
                ],
            ],
            'responsiveWrap' => false,
            'floatHeader' => true,
            'floatHeaderOptions' => [
                'position'=>'absolute',
                'top' => 50
            ],
            'hover' => true,
            'pager' => [
                'firstPageLabel' => Yii::t('backend', 'Primero'),
                'lastPageLabel' => Yii::t('backend', 'Último'),
            ],
            'hover' => true,
            'persistResize'=>true,
            'filterModel' => $searchModel,
            'columns' => [

				$custom_elements_gridview->getSerialColumn(),
                                    
				[
					'attribute'=>'user_id',
                    'format' => 'html',
					'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=> User::getSelectMap(),
					'filterWidgetOptions' => [
						'pluginOptions'=>['allowClear'=>true],
						'options'=>['multiple'=>false],
					],
                    'value'=> function($model){ return User::getFullNameByUserId($model->user_id); },
                    'filterInputOptions'=>['placeholder'=> '------'],
					'hAlign'=>'center',
                    'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
				],

				[
					'attribute'=>'payment_method_id',
                    'format' => 'html',
					'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=> PaymentMethod::getSelectMap(),
					'filterWidgetOptions' => [
						'pluginOptions'=>['allowClear'=>true],
						'options'=>['multiple'=>false],
					],
					'value'=> 'paymentMethod.name',
					'filterInputOptions'=>['placeholder'=> '------'],
					'hAlign'=>'center',
				],
                             
				[
					'attribute'=>'amount',
					'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
					'vAlign' => 'middle',
					'hAlign' => 'center',
					'pageSummary' => true,
					'pageSummaryFunc' => GridView::F_SUM,
                    'filterType'=>GridView::FILTER_NUMBER,
                    'filterWidgetOptions'=>[
                        'maskedInputOptions' => [
                            'allowMinus' => false,
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'digits' => 2
                        ],
                        'displayOptions' => ['class' => 'form-control kv-monospace'],
                        'saveInputContainer' => ['class' => 'kv-saved-cont']
                    ],
                    'value' => function ($data) {
                        return GlobalFunctions::formatNumber($data->amount,2);
                    },
                    'format' => 'html',
				],
                                     
				[
					'attribute'=>'total_to_pay',
					'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
					'vAlign' => 'middle',
					'hAlign' => 'center',
					'pageSummary' => true,
					'pageSummaryFunc' => GridView::F_SUM,
                    'filterType'=>GridView::FILTER_NUMBER,
                    'filterWidgetOptions'=>[
                        'maskedInputOptions' => [
                            'allowMinus' => false,
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'digits' => 2
                        ],
                        'displayOptions' => ['class' => 'form-control kv-monospace'],
                        'saveInputContainer' => ['class' => 'kv-saved-cont']
                    ],
                    'value' => function ($data) {
                        return GlobalFunctions::formatNumber($data->total_to_pay,2);
                    },
                    'format' => 'html',
				],
                                    
                [
                    'attribute'=>'source_account',
                    'headerOptions' => ['class'=>'custom_width'],
                    'contentOptions' => ['class'=>'custom_width'],
                    'hAlign'=>'center',
                    'format'=> 'html',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => Recharge::getFieldLabels('source_account'),
                    'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['multiple' => false],
                    ],
                    'filterInputOptions' => [
                    'placeholder' => '-----',
                    ]
                ],
                                        
                [
                    'attribute'=>'target_account',
                    'headerOptions' => ['class'=>'custom_width'],
                    'contentOptions' => ['class'=>'custom_width'],
                    'hAlign'=>'center',
                    'format'=> 'html',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => Recharge::getFieldLabels('target_account'),
                    'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['multiple' => false],
                    ],
                    'filterInputOptions' => [
                    'placeholder' => '-----',
                    ]
                ],

                [
                    'attribute'=>'status',
                    'headerOptions' => ['class'=>'custom_width'],
                    'contentOptions' => ['class'=>'custom_width'],
                    'hAlign'=>'center',
                    'format'=> 'html',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => \backend\models\UtilsConstants::getRechargeStatuses(),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                        'options' => ['multiple' => false],
                    ],
                    'filterInputOptions' => [
                        'placeholder' => '-----',
                    ],
                    'value' => function($model) {
                        return \backend\models\UtilsConstants::getRechargeStatuses($model->status);
                    }
                ],

                [
                    'attribute'=>'authorized_by',
                    'format' => 'html',
                    'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=> User::getSelectMap(),
                    'filterWidgetOptions' => [
                        'pluginOptions'=>['allowClear'=>true],
                        'options'=>['multiple'=>false],
                    ],
                    'value'=> function($model){ return User::getFullNameByUserId($model->authorized_by); },
                    'filterInputOptions'=>['placeholder'=> '------'],
                    'hAlign'=>'center',
                    'visible' => GlobalFunctions::getRol() === User::ROLE_SUPERADMIN
                ],
                                        
				$custom_elements_gridview->getActionColumn(),

				$custom_elements_gridview->getCheckboxColumn(),

            ],

            'toolbar' =>  $custom_elements_gridview->getToolbar(),

            'panel' => $custom_elements_gridview->getPanel(),

            'toggleDataOptions' => $custom_elements_gridview->getTogleDataOptions(),
        ]); ?>
    </div>

<?php
    $url = Url::to([$controllerId.'multiple_delete']);
    $js = Footer_Bulk_Delete::getFooterBulkDelete($url);
    $this->registerJs($js, View::POS_READY);
?>

