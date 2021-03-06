<?php

namespace backend\models\business;

use backend\components\QvaTel;
use backend\models\nomenclators\Country;
use backend\models\settings\Setting;
use backend\models\UtilsConstants;
use common\models\RegexCustomValidator;
use common\models\User;
use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "sms".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property string|null $receptor_country_id
 * @property string|null $receptor_phone_number
 * @property string|null $message
 * @property string|null $id_msg
 * @property string|null $response_qvatel
 * @property int|null $encrypt_type
 * @property int $status
 * @property float $cost
 * @property string $created_at
 * @property string $updated_at
 * @property string $programmer_date
 * @property int $type
 * @property int $count_consumed
 * @property string $res_multisms
 *
 * @property Country $country
 * @property Customer $customer
 * @property User $user

 */
class Sms extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $regex = new RegexCustomValidator();
        return [
            [['receptor_country_id', 'receptor_phone_number','message'], 'required'],
            [['user_id', 'customer_id', 'encrypt_type', 'status', 'receptor_country_id', 'type','count_consumed'], 'integer'],
            ['type', 'default', 'value' => Yii::$app->user->id],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
            ['status', 'default', 'value' => UtilsConstants::SMS_STATUS_SENDED],
            ['count_consumed', 'default', 'value' => 1],
           // [['message'], 'string', 'max' => 150],
            [['message', 'res_multisms', 'response_qvatel'], 'string'],
            [['created_at', 'updated_at', 'programmer_date'], 'safe'],
            [['id_msg'], 'string', 'max' => 255],
            ['cost','number'],
            ['receptor_phone_number', 'match', 'pattern' => $regex->getPatternOnlyNumber(), 'message' => $regex->getMessageOnlyNumber()],
            [['receptor_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['receptor_country_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'user_id' => Yii::t('backend', 'Creado por'),
            'customer_id' => Yii::t('backend', 'Env??a'),
            'receptor_country_id' => Yii::t('backend', 'Pa??s receptor'),
            'receptor_phone_number' => Yii::t('backend', 'Tel??fono receptor'),
            'message' => Yii::t('backend', 'Mensaje'),
            'encrypt_type' => Yii::t('backend', 'Tipo de encriptaci??n'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creaci??n'),
            'updated_at' => Yii::t('backend', 'Fecha de actualizaci??n'),
            'cost' => Yii::t('backend', 'Costo'),
            'id_msg' => Yii::t('backend', 'ID Qvatel'),
            'response_qvatel' => Yii::t('backend', 'Respuesta Qvatel'),
            'programmer_date' => Yii::t('backend', 'Fecha programado'),
            'type' => Yii::t('backend', 'Tipo'),
            'count_consumed' => Yii::t('backend', 'Mensajes consumidos'),
            'res_multisms' => Yii::t('backend', 'Respuestas multi-sms'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'receptor_country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /** :::::::::::: START > Abstract Methods and Overrides ::::::::::::*/

    /**
    * @return string The base name for current model, it must be implemented on each child
    */
    public function getBaseName()
    {
        return StringHelper::basename(get_class($this));
    }

    /**
    * @return string base route to model links, default to '/'
    */
    public function getBaseLink()
    {
        return "/sms";
    }

    /**
    * Returns a link that represents current object model
    * @return string
    *
    */
    public function getIDLinkForThisModel()
    {
        $id = $this->getRepresentativeAttrID();
        if (isset($this->$id)) {
            $name = $this->getRepresentativeAttrName();
            return Html::a($this->$name, [$this->getBaseLink() . "/view", 'id' => $this->getId()]);
        } else {
            return GlobalFunctions::getNoValueSpan();
        }
    }

    /** :::::::::::: END > Abstract Methods and Overrides ::::::::::::*/

    public function getFullPhoneNumber() {
        return '+'.$this->country->phone_code.''.$this->receptor_phone_number;
    }
    public static function getTotalSms() {
        $query = Sms::find();

        if(!User::isSuperAdmin()) {
            $query->andWhere(['user_id' =>Yii::$app->user->id]);
        }

        $result = $query->count();

        return $result?? 0;
    }

    public static function getTotalSmsGroup() {
        $query = SmsGroup::find();

        if(!User::isSuperAdmin()) {
            $query->andWhere(['user_id' =>Yii::$app->user->id]);
        }

        $result = $query->count();

        return $result?? 0;
    }

    public function getStatusWithTags()
    {
        $status = (int) $this->status;
        $status_label = UtilsConstants::getSmsStatuses($this->status);

        if($status === UtilsConstants::SMS_STATUS_SENDED) {
            $result = Html::tag('span', $status_label, ['class' => 'badge bg-gray']);
        } elseif($status === UtilsConstants::SMS_STATUS_PENDING) {
            $result = Html::tag('span', $status_label, ['class' => 'badge bg-orange']);
        } elseif($status === UtilsConstants::SMS_STATUS_SUCCESS) {
            $result = Html::tag('span', $status_label, ['class' => 'badge bg-green']);
        } elseif($status === UtilsConstants::SMS_STATUS_FAIL) {
            $result = Html::tag('span', $status_label, ['class' => 'badge bg-red']);
        } else {
            $result = Html::tag('span', $status_label, ['class' => 'badge bg-gray']);
        }

        return $result;

    }


    public static function getTokenQvatel() {
        $token = Setting::getValueOfFieldName('token_qvatel');
        $api_token = (isset($token) && !empty($token))? $token : UtilsConstants::API_TOKEN_QVATEL;

        return $api_token;
    }

    public function sendSms() {
        $receptor_country = Country::findOne($this->receptor_country_id);
        $phone = $receptor_country->phone_code.$this->receptor_phone_number;
        $message = $this->message;

        /** Verificar si el mensaje es mayor que 150 caracteres para picarlo y enviar multiples mensajes **/
        $total_characters = strlen($message);
        $total_sms = ceil($total_characters/150);
        if($total_sms > 1) {
            $start = 0;
            $list_multi_sms = [];

            for($i=0; $i<$total_sms; $i++)
            {
                $extract_temp = substr($message,$start,150);
                $response = $this->sendSmsQvatel($phone, $extract_temp);

                if($response)
                {
                    $resObj = json_decode($response);
                    $result = (int) $resObj->result;

                    if($result === 1) {
                        $list_multi_sms[$i] = [
                            'response_qvatel' => $response,
                            'status' => UtilsConstants::SMS_STATUS_SENDED,
                            'id_msg' => $resObj->id_msg,
                        ];
                    }
                    else
                    {
                        $list_multi_sms[$i] = [
                            'response_qvatel' => $response,
                            'status' => UtilsConstants::SMS_STATUS_FAIL,
                            'id_msg' => '',
                        ];
                    }
                }
                else
                {
                    $list_multi_sms[$i] = [
                        'response_qvatel' => '',
                        'status' => UtilsConstants::SMS_STATUS_FAIL,
                        'id_msg' => '',
                    ];
                }

                if($i > 1) {
                    $start = 150*$i +1;
                } else {
                    $start = 151;
                }
            }

            $this->res_multisms = json_encode($list_multi_sms);

            return true;
        }
        else
        {
            $response = $this->sendSmsQvatel($phone, $message);

            if($response) {
                $this->response_qvatel = $response;
                $resObj = json_decode($response);
                $result = (int) $resObj->result;

                if($result === 1) {
                    $this->id_msg = $resObj->id_msg;
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * @param $phone
     * @param $message
     * @return bool|mixed|string
     */
    private function sendSmsQvatel($phone, $message) {
        $api_token = self::getTokenQvatel();
        $qvatel  = new QvaTel($api_token);

        try
        {
            /** Para enviar un sms  */
            $response = $qvatel->enviar_sms($phone, $message);

            if($response) {
                return $response;
            }
        }
        catch (\Exception $e)
        {
            return false;
        }

        return false;
    }

    public function checkStatus() {
        $api_token = self::getTokenQvatel();
        $qvatel  = new QvaTel($api_token);
        $total_sms = (int) $this->count_consumed;
        $count_sms_sent = 0;

        if($total_sms > 1)
        {
            if($this->res_multisms !== null) {
                $multi_response = json_decode($this->res_multisms);

                for($i=0; $i<$total_sms; $i++)
                {
                    $id_msg = ($multi_response[$i]->id_msg !== '')? $multi_response[$i]->id_msg : false;

                    if($id_msg) {
                        $response = $qvatel->reporte_sms($id_msg);

                        if($response)
                        {
                            $resObj = json_decode($response);
                            $result = (int) $resObj->result;

                            if($result === 1)
                            {
                                $status = $resObj->estado;
                                if($status == 'Entregado') {
                                    $multi_response[$i]->status = UtilsConstants::SMS_STATUS_SUCCESS;
                                    $count_sms_sent++;
                                } elseif ($status == 'Pendiente') {
                                    $multi_response[$i]->status = UtilsConstants::SMS_STATUS_PENDING;
                                } elseif ($status == 'Fallido') {
                                    $multi_response[$i]->status = UtilsConstants::SMS_STATUS_FAIL;
                                }
                            }
                            else {
                                $multi_response[$i]->status = UtilsConstants::SMS_STATUS_FAIL;
                            }
                        }
                    }
                }

                if($count_sms_sent === $this->count_consumed)
                {
                    $this->res_multisms = json_encode($multi_response);
                    $this->status = UtilsConstants::SMS_STATUS_SUCCESS;

                    $this->save();

                    return true;
                }
                else {
                    return false;
                }
            }
        }
        else
        {
            if($this->id_msg !== null) {
                $response = $qvatel->reporte_sms($this->id_msg);
                if($response) {
                    $resObj = json_decode($response);
                    $result = (int) $resObj->result;

                    if($result === 1) {
                        $status = $resObj->estado;
                        if($status == 'Entregado') {
                            $this->status = UtilsConstants::SMS_STATUS_SUCCESS;
                        } elseif ($status == 'Pendiente') {
                            $this->status = UtilsConstants::SMS_STATUS_PENDING;
                        } elseif ($status == 'Fallido') {
                            $this->status = UtilsConstants::SMS_STATUS_FAIL;
                        }

                        $this->save();

                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }

        }

        return true;
    }

    public function fields()
    {
        $result = parent::fields();

        unset($result['id_msg']);
        unset($result['encrypt_type']);
        unset($result['response_qvatel']);
        unset($result['updated_at']);

        $result['country_name'] = function ($model) {
            return $model->country->name;
        };

        $result['customer_name'] = function ($model) {
            return ($model->customer_id)? $model->customer->name : null;
        };

        $result['status_name'] = function ($model) {
            return UtilsConstants::getSmsStatuses($model->status);
        };

        $result['receptor_full_phone_number'] = function ($model) {
            return '+'.$model->country->phone_code.''.$model->receptor_phone_number;
        };

        $result['type_label'] = function ($model) {
            return UtilsConstants::getSmsType($model->type);
        };

        return $result;
    }

    public static function checkSmsProgramed() {
        $all_sms = self::findAll(['status' => UtilsConstants::SMS_STATUS_PROGRAMED]);
        $total_sms_sent = 0;
        if($all_sms !== null) {
            foreach ($all_sms AS $key => $model) {
                $time_programed = strtotime($model->programmer_date);
                $current_time = time();
                if($time_programed <= $current_time) {
                    $model->status = UtilsConstants::SMS_STATUS_SENDED;
                    if($model->sendSms()) {
                        //descontar del balance del usuario
                        User::updateBalance($model->user_id,UtilsConstants::UPDATE_NUMBER_MINUS,$model->cost);
                    }
                    $total_sms_sent++;
                    $model->save(false);
                }

            }
        }

        return $total_sms_sent;
    }

}
