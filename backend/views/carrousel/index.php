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
use backend\models\settings\Carrousel;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\settings\CarrouselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$controllerId = '/'.$this->context->uniqueId.'/';
$this->title = Yii::t('backend', 'Carrousels');
$this->params['breadcrumbs'][] = $this->title;

$create_button='';
?>

<?php 
	if (Helper::checkRoute($controllerId . 'create')) {
		$create_button = Html::a('<i class="fa fa-plus"></i> '.Yii::t('backend', 'Crear'), ['create'], ['class' => 'btn btn-default btn-flat margin', 'title' => Yii::t('backend', 'Crear').' '.Yii::t('backend', 'Carrousel')]);
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
                    'attribute'=>'name',
                    'headerOptions' => ['class'=>'custom_width'],
                    'contentOptions' => ['class'=>'custom_width'],
                    'hAlign'=>'center',
                    'format'=> 'html',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => Carrousel::getFieldLabels('name'),
                    'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['multiple' => false],
                    ],
                    'filterInputOptions' => [
                    'placeholder' => '-----',
                    ]
                ],

                                         
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return GlobalFunctions::getStatusValue($data->status);
                    },
                    'filter' => [
                        0 =>  Yii::t('backend','Inactivo'),
                        1 => Yii::t('backend','Activo')
                    ],
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'------'],
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

