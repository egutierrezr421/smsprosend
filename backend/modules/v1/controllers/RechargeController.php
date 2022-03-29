<?php

namespace backend\modules\v1\controllers;

use backend\models\business\RechargeSearch;
use backend\models\UtilsConstants;
use backend\modules\v1\ApiUtilsFunctions;
use common\models\GlobalFunctions;
use common\models\User;
use Yii;
use yii\db\Exception;
use yii\filters\auth\QueryParamAuth;
use backend\models\business\Recharge;

/**
 * Recharge controller for the `v1` module
 */
class RechargeController extends ApiController
{
    public $modelClass = 'backend\models\business\Recharge';

    public $serializer = [
        'class' => 'backend\modules\v1\CustomSerializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['create'], $actions['update'], $actions['delete']);

        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' => function () {
                $searchModel = new RechargeSearch();
                $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);

                return $dataProvider;
            },
        ];

        return $actions;
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['POST', 'PUT', 'PATCH'],
            'delete' => ['POST', 'DELETE'],
            'approv' => ['POST'],
        ];
    }

    public function actionView($id)
    {
        $model = Recharge::findOne($id);

        if ($model !== null) {
            return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_SUCCESS,'',$model);
        } else {
            ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_NOTFOUND);
        }
    }

    public function actionUpdate($id)
    {
        $model = Recharge::findOne($id);

        if (isset($model) && !empty($model))
        {
            $params = $this->getRequestParamsAsArray();
            $model->load($params, '');

            if (!$model->validate()) {
                $message = Yii::t('backend', 'Error actualizando el elemento');
                return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_ERROR, $message, $model->getFirstErrors());
            }

            $transaction = \Yii::$app->db->beginTransaction();

            try {

                if ($model->save())
                {
                    $transaction->commit();
                    $model->refresh();
                    $message = Yii::t('backend', 'Elemento actualizado correctamente');
                    return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_SUCCESS, $message, $model);
                } else {
                    $message = Yii::t('backend', 'Error actualizando el elemento');
                    return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_ERROR, $message, $model->getFirstErrors());
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                $message = Yii::t('backend', 'Error, ha ocurrido una excepción creando el elemento');
                return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_ERROR, $message, $e->getMessage());
            }
        } else {
            ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_NOTFOUND);
        }
    }

    public function actionApprov($id)
    {
        $model = Recharge::findOne($id);

        if (isset($model) && !empty($model))
        {
            $model->status = UtilsConstants::RECHARGE_STATUS_APPROVED;

            $transaction = \Yii::$app->db->beginTransaction();

            try {

                if ($model->save())
                {
                    $transaction->commit();
                    $model->refresh();
                    $message = Yii::t('backend', 'Elemento actualizado correctamente');
                    return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_SUCCESS, $message, $model);
                } else {
                    $message = Yii::t('backend', 'Error actualizando el elemento');
                    return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_ERROR, $message, $model->getFirstErrors());
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                $message = Yii::t('backend', 'Error, ha ocurrido una excepción creando el elemento');
                return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_ERROR, $message, $e->getMessage());
            }
        } else {
            ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_NOTFOUND);
        }
    }

}
