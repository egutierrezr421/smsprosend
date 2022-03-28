<?php

namespace backend\modules\v1\controllers;

use backend\models\business\Sms;
use backend\models\UtilsConstants;
use backend\modules\v1\ApiUtilsFunctions;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * ReceiveController for the `v1` module
 */
class ReceiveController extends ApiController
{
    public $modelClass = '';

    /**
     * Format response to JSON
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        return $behaviors;
    }

    public function actionNotifyDelivery()
    {
        $params = $this->getRequestParamsAsArray();
        $id_msg = ArrayHelper::getValue($params, "id_msg");
        $status = ArrayHelper::getValue($params, "estado");

        if($id_msg !== null) {
            $model = Sms::findOne(['id_msg' => $id_msg]);
            if($model !== null) {
                if($status == 'Entregado') {
                    $model->status = UtilsConstants::SMS_STATUS_SUCCESS;
                } elseif ($status == 'Pendiente') {
                    $model->status = UtilsConstants::SMS_STATUS_PENDING;
                } elseif ($status == 'Fallido') {
                    $model->status = UtilsConstants::SMS_STATUS_FAIL;
                }

                $model->save(false);
            }
        }

        return true;
    }
}

