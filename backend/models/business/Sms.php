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
            [['user_id', 'customer_id', 'encrypt_type', 'status', 'receptor_country_id'], 'integer'],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
            ['status', 'default', 'value' => UtilsConstants::SMS_STATUS_SENDED],
            [['message'], 'string', 'max' => 150],
            [['created_at', 'updated_at'], 'safe'],
            [['id_msg'], 'string', 'max' => 255],
            [['response_qvatel'], 'string'],
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
            'customer_id' => Yii::t('backend', 'Envía'),
            'receptor_country_id' => Yii::t('backend', 'País receptor'),
            'receptor_phone_number' => Yii::t('backend', 'Teléfono receptor'),
            'message' => Yii::t('backend', 'Mensaje'),
            'encrypt_type' => Yii::t('backend', 'Tipo de encriptación'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
            'cost' => Yii::t('backend', 'Costo'),
            'id_msg' => Yii::t('backend', 'ID Qvatel'),
            'response_qvatel' => Yii::t('backend', 'Respuesta Qvatel'),
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
        $api_token = self::getTokenQvatel();
        $qvatel  = new QvaTel($api_token);

        $receptor_country = Country::findOne($this->receptor_country_id);
        $phone = $receptor_country->phone_code.$this->receptor_phone_number;
        $message = $this->message;

        /** Para enviar un sms  */
        $response = $qvatel->enviar_sms($phone, $message);

        $this->response_qvatel = $response;
        if($response) {
            $resObj = json_decode($response);
            $result = (int) $resObj->result;

            if($result === 1) {
                $this->id_msg = $resObj->id_msg;

                return true;
            }
        }

        return false;
    }

    public function checkStatus() {
        $api_token = self::getTokenQvatel();
        $qvatel  = new QvaTel($api_token);

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
        }

        return false;
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

        return $result;
    }

}
