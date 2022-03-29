<?php

namespace backend\models\business;

use backend\models\nomenclators\Country;
use backend\models\UtilsConstants;
use common\models\RegexCustomValidator;
use common\models\User;
use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $country_id
 * @property string|null $name
 * @property string|null $code
 * @property string|null $phone_number
 * @property string|null $token
 * @property int $status
 * @property int $allow_send_sms
 * @property int $send_sms_type
 * @property int $max_sms
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Country $country
 * @property User $user
 * @property CustomerHasGroupCustomer[] $customerHasGroupCustomers
 * @property GroupCustomer[] $groupCustomers

 */
class Customer extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $regex = new RegexCustomValidator();
        return [
            [['name','country_id','phone_number'], 'required'],
            [['user_id', 'country_id', 'status', 'allow_send_sms' , 'send_sms_type', 'max_sms'], 'integer'],
            ['phone_number', 'match', 'pattern' => $regex->getPatternOnlyNumber(), 'message' => $regex->getMessageOnlyNumber()],
            [['code'], 'default', 'value' => function ($model, $attribute) {
                return  time();
            }],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
            [['token'], 'default', 'value' => function ($model, $attribute) {
                return self::generateToken();
            }],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'country_id' => Yii::t('backend', 'País'),
            'name' => Yii::t('backend', 'Nombre'),
            'code' => Yii::t('backend', 'Código'),
            'phone_number' => Yii::t('backend', 'Teléfono'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
            'allow_send_sms' => Yii::t('backend', 'Acceso a SMS'),
            'send_sms_type' => Yii::t('backend', 'Tipo de acceso'),
            'max_sms' => Yii::t('backend', 'SMS permitidos'),
            'token' => Yii::t('backend', 'Token'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerHasGroupCustomers()
    {
        return $this->hasMany(CustomerHasGroupCustomer::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupCustomers()
    {
        return $this->hasMany(GroupCustomer::className(), ['id' => 'group_customer_id'])->viaTable('customer_has_group_customer', ['customer_id' => 'id']);
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
        return "/customer";
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

    /**
     * Returns a mapped array for using on Select widget
     *
     * @param boolean $check_status
     * @return array
     */
    public static function getSelectMap($check_status = false)
    {
        $query = self::find()->select(['id','name']);

        if($check_status)
        {
            $query->where(['status' => self::STATUS_ACTIVE]);
        }

        if(!User::isSuperAdmin()) {
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $models = $query->asArray()->all();

        $array_map = [];

        if(count($models)>0)
        {
            foreach ($models AS $index => $model)
            {
                $array_map[$model['id']] = $model['name'];
            }
        }

        return $array_map;
    }

    /**
     * @param int $longitude
     * @return string
     * @throws \Exception
     */
    public static function generateToken($longitude = 15) {
        return UtilsConstants::PREFIX_TOKEN_CUSTOMER.''.bin2hex(random_bytes(($longitude - ($longitude % 2)) / 2));
    }

    public static function minusLimitSms($customer_id, $quantity) {
        $model = self::findOne($customer_id);
        if($model !== null) {

            $type_access = (int) $model->send_sms_type;
            if($type_access === UtilsConstants::TYPE_ACCESS_API_CUSTOMER_LIMIT_SMS && isset($model->max_sms) && !empty($model->max_sms)) {
                $current_qty = (int) $model->max_sms;

                if($quantity >= $current_qty)
                {
                    $model->max_sms = 0;
                }
                else {
                    $model->max_sms = $model->max_sms - $quantity;
                }

                $model->save(false);
            }
        }
    }
}
