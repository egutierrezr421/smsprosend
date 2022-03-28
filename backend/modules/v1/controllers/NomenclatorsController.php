<?php

namespace backend\modules\v1\controllers;

use backend\models\nomenclators\Country;
use backend\models\nomenclators\PaymentMethod;
use backend\models\UtilsConstants;
use backend\modules\v1\ApiUtilsFunctions;
use yii\rest\ActiveController;

/**
 * NomenclatorsController for the `v1` module
 */
class NomenclatorsController extends ActiveController
{
    public $modelClass = '';

    public function actionGetSmsStatuses()
    {
        $data[] = UtilsConstants::getSmsStatuses();
        return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_INDEX_RESPONSE,'',$data);
    }

    public function actionGetCountries()
    {
        $data = Country::findAll(['status' => 1]);
        return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_INDEX_RESPONSE,'',$data);
    }

    public function actionGetPaymentMethods()
    {
        $data = PaymentMethod::findAll(['status' => 1]);
        return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_INDEX_RESPONSE,'',$data);
    }

    public function actionGetCustomerSmsAccessTypes()
    {
        $data = UtilsConstants::getCustomerSmsAccessType();
        return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_INDEX_RESPONSE,'',$data);
    }

}

