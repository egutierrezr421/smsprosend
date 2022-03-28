<?php

namespace backend\models\business;

use common\models\User;
use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "sms_group".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property string|null $message
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Customer $customer
 * @property User $user
 * @property GroupCustomerHasSmsGroup[] $groupCustomerHasSmsGroups
 * @property Sms[] $sms
 */
class SmsGroup extends BaseModel
{
    public $group_customer_list;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'group_customer_list'], 'required'],
            [['user_id', 'customer_id', 'status'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at', 'group_customer_list'], 'safe'],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
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
            'message' => Yii::t('backend', 'Mensaje'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
            'group_customer_list' => Yii::t('backend', 'Grupos de clientes'),
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupCustomerHasSmsGroups()
    {
        return $this->hasMany(GroupCustomerHasSmsGroup::className(), ['sms_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSms()
    {
        return $this->hasMany(Sms::className(), ['id' => 'sms_id'])->viaTable('sms_has_sms_group', ['sms_group_id' => 'id']);
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
        return "/sms-group";
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

}
