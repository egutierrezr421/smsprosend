<?php

namespace backend\modules\v1\controllers;

use backend\models\business\Recharge;
use backend\models\business\Sms;
use backend\models\business\SmsSearch;
use backend\models\nomenclators\Country;
use backend\models\UtilsConstants;
use backend\modules\v1\ApiUtilsFunctions;
use common\models\User;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;


/**
 * Sms controller for the `v1` module
 */
class SmsController extends ApiController
{
    public $modelClass = 'backend\models\business\Sms';

    public $serializer = [
        'class' => 'backend\modules\v1\CustomSerializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['index'], $actions['view'], $actions['update']);

        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'prepareDataProvider' => function () {
                $searchModel = new SmsSearch();
                $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);

                return $dataProvider;
            },
        ];

        return $actions;
    }

    public function actionIndex()
    {
        $data = Sms::find()->all();

        return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_INDEX_RESPONSE,'',$data);
    }

    public function actionView($id)
    {
        $model = Sms::findOne($id);

        if ($model !== null) {
            return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_SUCCESS,'',$model);
        } else {
            ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_NOTFOUND);
        }
    }

    public function actionSend()
    {
        $params = $this->getRequestParamsAsArray();

        if(Recharge::getAvailableBalance() === 0) {
            return ApiUtilsFunctions::getResponseType(
                ApiUtilsFunctions::TYPE_ERROR,
                Yii::t("backend", "Balance insuficiente, por favor recargue")
            );
        }

        $receptor_country_id = ArrayHelper::getValue($params, "receptor_country_id", null);
        if($receptor_country_id !== null) {
            $receptor_country = Country::findOne($receptor_country_id);
            $cost = $receptor_country->sms_price;
        }

        $model = new Sms([
            'user_id' => Yii::$app->user->id,
            'customer_id' => ArrayHelper::getValue($params, "customer_id", null),
            'message' => ArrayHelper::getValue($params, "message", null),
            'receptor_country_id' => $receptor_country_id,
            'receptor_phone_number' => ArrayHelper::getValue($params, "receptor_phone_number", null),
            'status' => UtilsConstants::SMS_STATUS_SENDED,
            'cost' => (isset($cost) && !empty($cost))? $cost : 0.05,
        ]);

        $transaction = \Yii::$app->db->beginTransaction();

        try
        {

            $current_balance = Recharge::getAvailableBalance();
            if($model->cost > $current_balance) {
                return ApiUtilsFunctions::getResponseType(
                    ApiUtilsFunctions::TYPE_ERROR,
                    Yii::t("backend", "Balance insuficiente, por favor recargue")
                );
            }

            if($model->validate() && $model->sendSms() && $model->save())
            {
                $transaction->commit();

                return ApiUtilsFunctions::getResponseType(
                    ApiUtilsFunctions::TYPE_SUCCESS,
                    Yii::t("backend", "Sms enviado correctamente")
                );
            }
            else
            {
                return ApiUtilsFunctions::getResponseType(
                    ApiUtilsFunctions::TYPE_ERROR,
                    Yii::t("backend", "Error enviando el sms"),
                    $model->getFirstErrors()
                );
            }
        }
        catch (Exception $e)
        {
            $transaction->rollBack();
            return ApiUtilsFunctions::getResponseType(
                ApiUtilsFunctions::TYPE_ERROR,
                Yii::t("backend", "Error, ha ocurrido una excepción enviando el sms"),
                $e->getMessage()
            );
        }

    }

    public function actionCheckStatus($id_msg = null) {

        $query = Sms::find()->where(['status' => [UtilsConstants::SMS_STATUS_SENDED, UtilsConstants::SMS_STATUS_PENDING]]);

        if($id_msg !== null) {
            $query->andWhere(['id_msg' => $id_msg]);
        }

        if(!User::isSuperAdmin()) {
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $models = $query->all();

        $count_items = count($models);

        $updateOK = true;
        $nameErrorUpdate = '';
        $contNameErrorUpdate  = 0;

        foreach ($models as $key => $model) {
            if(!$model->checkStatus()) {
                $updateOK=false;
                $nameErrorUpdate= $nameErrorUpdate.'['.$model->id_msg.'] ';
                $contNameErrorUpdate ++;
            }
        }

        if($updateOK) {
            if($count_items === 1) {
                $message = Yii::t('backend','Estado chequeado correctamente');
            } else {
                $message = Yii::t('backend','Estados chequeados correctamente');
            }

            return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_SUCCESS, $message);

        } else {
            if($count_items === 1) {
                if($contNameErrorUpdate ===1) {
                    $message = Yii::t('backend','Error chequeando estado del elemento').': <b>'.$nameErrorUpdate.'</b>';
                }
            } else {
                if($contNameErrorUpdate ===1) {
                    $message = Yii::t('backend','Error chequeando estado del elemento').': <b>'.$nameErrorUpdate.'</b>';
                } elseif($contNameErrorUpdate >1) {
                    $message = Yii::t('backend','Error chequeando estados de los elementos').': <b>'.$nameErrorUpdate.'</b>';
                }
            }

            return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_ERROR,$message);
        }
    }

}
