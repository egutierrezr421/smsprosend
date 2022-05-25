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
use backend\models\nomenclators\RechargeEtecsaType;
use common\models\User;
use backend\models\business\Customer;
use backend\models\business\RechargeEtecsa;
use backend\models\UtilsConstants;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\business\RechargeEtecsaSearch */
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
					'attribute'=>'recharge_etecsa_type_id',
                    'format' => 'html',
					'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=> RechargeEtecsaType::getSelectMap(),
					'filterWidgetOptions' => [
						'pluginOptions'=>['allowClear'=>true],
						'options'=>['multiple'=>false],
					],
					'value'=> 'rechargeEtecsaType.name',
					'filterInputOptions'=>['placeholder'=> '------'],
					'hAlign'=>'center',
				],
                                                            
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
                    'attribute'=>'type',
                    'format' => 'html',
                    'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=> UtilsConstants::getRechargeType(),
                    'filterWidgetOptions' => [
                        'pluginOptions'=>['allowClear'=>true],
                        'options'=>['multiple'=>false],
                    ],
                    'filterInputOptions'=>['placeholder'=> '------'],
                    'hAlign'=>'center',
                    'value' => function($model) {
                        return UtilsConstants::getRechargeType($model->type);
                    }
                ],

                [
                    'attribute'=>'quantity',
                    'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
                    'vAlign' => 'middle',
                    'hAlign'=>'center',
                    'filterType'=>GridView::FILTER_NUMBER,
                    'filterWidgetOptions'=>[
                        'maskedInputOptions' => [
                            'allowMinus' => false,
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'digits' => 0
                        ],
                        'displayOptions' => ['class' => 'form-control kv-monospace'],
                        'saveInputContainer' => ['class' => 'kv-saved-cont']
                    ],
                    'value' => function ($data) {
                        return GlobalFunctions::formatNumber($data->quantity);
                    },
                    'format' => 'html',
                ],
                                 
				[
					'attribute'=>'total_cost',
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
                        return GlobalFunctions::formatNumber($data->total_cost,2);
                    },
                    'format' => 'html',
				],

                [
                    'attribute'=>'status',
                    'format' => 'html',
                    'contentOptions'=>['class'=>'kv-align-left kv-align-middle'],
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=> UtilsConstants::getStatusRechargeEtecsa(),
                    'filterWidgetOptions' => [
                        'pluginOptions'=>['allowClear'=>true],
                        'options'=>['multiple'=>false],
                    ],
                    'filterInputOptions'=>['placeholder'=> '------'],
                    'hAlign'=>'center',
                    'value' => function($model) {
                        return UtilsConstants::getRechargeType($model->status);
                    }
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

