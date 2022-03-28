<?php

namespace backend\modules\v1\controllers;

use backend\models\business\Customer;
use backend\models\business\Recharge;
use backend\models\business\Sms;
use backend\models\business\SmsSearch;
use backend\models\nomenclators\Country;
use backend\models\settings\Setting;
use backend\models\UtilsConstants;
use backend\modules\v1\ApiUtilsFunctions;
use common\models\GlobalFunctions;
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
            'checkAccess' => function() {
                $params = $this->getRequestParamsAsArray();
                $result_access = $this->checkAccess($this->action->id,null,$params);
            }
        ];

        return $actions;
    }

    public function actionView($id)
    {
        $params = $this->getRequestParamsAsArray();
        $result_access = $this->checkAccess($this->action->id,null,$params);

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
        $result_access = $this->checkAccess($this->action->id,null,$params);
        $user_id = $result_access['user_id'];
        $customer_id = $result_access['customer_id'];
        $count_sms = 0;

        //Validar que la oficina esté abierta
        $office_status = (int) Setting::getValueOfFieldName('office_status');
        if(!$office_status) {
            return ApiUtilsFunctions::getResponseType(
                ApiUtilsFunctions::TYPE_ERROR,
                Yii::t("backend", "Error enviando el sms. Oficina cerrada")
            );
        }

        //Validar que el usuario tenga balance disponible
        if(Recharge::getAvailableBalance($user_id) === 0)
        {
            return ApiUtilsFunctions::getResponseType(
                ApiUtilsFunctions::TYPE_ERROR,
                Yii::t("backend", "Balance insuficiente, por favor recargue")
            );
        }


        //Validar que se recibe el paramtro receptor commo arreglo y que el costo del envio no supere el balance del usuario
        $receptors_array = ArrayHelper::getValue($params, "receptors", []);
        $total_cost = 0;
        $count_sms = count($receptors_array);
        if($count_sms > 0) {
            foreach ($receptors_array AS $index => $value) {
                $receptor_country = Country::findOne($value['country_id']);
                $total_cost += $receptor_country->sms_price;
            }

            if($total_cost > Recharge::getAvailableBalance($user_id)) {
                return ApiUtilsFunctions::getResponseType(
                    ApiUtilsFunctions::TYPE_ERROR,
                    Yii::t("backend", "Balance insuficiente, por favor recargue")
                );
            }
        }
        else
        {
            return ApiUtilsFunctions::getResponseType(
                ApiUtilsFunctions::TYPE_ERROR,
                Yii::t("backend", "Receptors no puede estar vacío")
            );
        }

        //Si el envío es con el token de un cliente validar que pueda enviar sms.
        // No es necesario validar si el tipo de acceso es balance debido a que utiliza el balance del usuario
        if($customer_id !== null)
        {
            $customer = Customer::findOne($customer_id);
            if($customer !== null) {
                $access_type = (int) $customer->send_sms_type;
                if($access_type === UtilsConstants::TYPE_ACCESS_API_CUSTOMER_LIMIT_SMS) {
                    if (!isset($customer->max_sms) || empty($customer->max_sms) || $customer->max_sms < $count_sms)
                    {
                        return ApiUtilsFunctions::getResponseType(
                            ApiUtilsFunctions::TYPE_ERROR,
                            Yii::t("backend", "Error, la cantidad de SMS a enviar supera el límite de envío asignado al cliente")
                        );
                    }
                }
            }
        }

        $sendOK = true;
        $nameErrorSend = '';
        $contNameErrorSend  = 0;
        $contOk  = 0;
        $receptors = ArrayHelper::getValue($params, "receptors", null);
        $count_items = count($receptors);

        foreach ($receptors AS $key => $value) {

            $receptor_country = Country::findOne($value['country_id']);
            $cost = $receptor_country->sms_price;
            $phone_number_complete = '+'.$receptor_country->phone_code.''.$value['phone_number'];

            $model = new Sms([
                'user_id' => $result_access['user_id'],
                'customer_id' => $result_access['customer_id'],
                'message' => ArrayHelper::getValue($params, "message", null),
                'receptor_country_id' => $receptor_country->id,
                'receptor_phone_number' => $value['phone_number'],
                'status' => UtilsConstants::SMS_STATUS_SENDED,
                'cost' => (isset($cost) && !empty($cost))? $cost : 0.05,
            ]);

            if($model->validate() && $model->sendSms() && $model->save())
            {
                $contOk++;
            }
            else {
                $sendOK=false;
                $nameErrorSend= $nameErrorSend.'['.$phone_number_complete.'] ';
                $contNameErrorSend ++;
            }
        }

        if($sendOK) {
            if($count_items === 1) {
                $message = Yii::t('backend','Mensaje enviado correctamente');
            } else {
                $message = Yii::t('backend','Mensajes enviados correctamente');
            }

            if($customer_id !== null) {
                Customer::minusLimitSms($customer_id, $contOk);
            }

            return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_SUCCESS, $message);

        } else {
            if($count_items === 1) {
                if($contNameErrorSend ===1) {
                    $message = Yii::t('backend','Error enviando mensaje para').': <b>'.$nameErrorSend.'</b>';
                }
            } else {
                if($contNameErrorSend ===1) {
                    $message = Yii::t('backend','Error enviando mensaje para').': <b>'.$nameErrorSend.'</b>';
                } elseif($contNameErrorSend >1) {
                    $message = Yii::t('backend','Error enviando mensajes para').': <b>'.$nameErrorSend.'</b>';
                }
            }

            return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_ERROR, $message);
        }
    }

    public function actionCheckStatus($id = null)
    {
        $params = $this->getRequestParamsAsArray();
        $result_access = $this->checkAccess($this->action->id,null,$params);

        $query = Sms::find()->where(['status' => [UtilsConstants::SMS_STATUS_SENDED, UtilsConstants::SMS_STATUS_PENDING]]);

        if($id !== null) {
            $query->andWhere(['id' => $id]);
        }

        if(GlobalFunctions::getRol($result_access['user_id']) !== User::ROLE_SUPERADMIN) {
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
                $nameErrorUpdate= $nameErrorUpdate.'['.$model->id.'] ';
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

    public function checkAccess($action, $model = null, $params = [])
    {
        $allow_access = false;

        $access_token = ArrayHelper::getValue($params, "access-token", null);
        $app_token = ArrayHelper::getValue($params, "app-token", null);
        $customer_token = ArrayHelper::getValue($params, "customer-token", null);

        if(isset($access_token) && !empty($access_token))
        {
            $user = User::findIdentityByAccessToken($access_token);
            $allow_access = ($user !== null);
            if(!$allow_access) {
                return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_FORBIDDEN,Yii::t('backend','Token de acceso no válido'));
            }
            $result = ['user_id' => $user->id, 'customer_id' => null];
        }
        elseif(isset($app_token) && !empty($app_token))
        {
            $user = User::find()->innerJoinWith('appAccesses')->where(['app_access.token' => $app_token])->one();
            $allow_access = ($user !== null);
            if(!$allow_access) {
                return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_FORBIDDEN,Yii::t('backend','Token de acceso no válido'));
            }
            $result = ['user_id' => $user->id, 'customer_id' => null];
        }
        elseif(isset($customer_token) && !empty($customer_token))
        {
            $customer = Customer::find()->where(['token' => $customer_token,'allow_send_sms' => 1])->one();
            $allow_access = ($customer !== null);
            if(!$allow_access) {
                return ApiUtilsFunctions::getResponseType(ApiUtilsFunctions::TYPE_FORBIDDEN,Yii::t('backend','Token de acceso no válido'));
            }
            $result = ['user_id' => $customer->user_id, 'customer_id' => $customer->id];

        }

        return $result;
    }


}
