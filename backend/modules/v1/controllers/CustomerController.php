<?php

namespace backend\modules\v1\controllers;

use backend\models\business\CustomerSearch;
use backend\modules\v1\ApiUtilsFunctions;
use common\models\GlobalFunctions;
use common\models\User;
use Yii;
use yii\filters\auth\QueryParamAuth;
use backend\models\business\Customer;

/**
 * Customer controller for the `v1` module
 */
class CustomerController extends ApiController
{
    public $modelClass = 'backend\models\business\Customer';

    public $serializer = [
        'class' => 'backend\modules\v1\CustomSerializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['view']);
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' => function () {
                $searchModel = new CustomerSearch();
                $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);

                return $dataProvider;
            },
        ];

        return $actions;
    }

    public function actionIndex()
    {
        $data = Customer::find()->all();

        return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_INDEX_RESPONSE,'',$data);
    }

    public function actionView($id)
    {
        $model = Customer::findOne($id);

        if ($model !== null) {
            return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_SUCCESS,'',$model);
        } else {
            ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_NOTFOUND);
        }
    }
}
