<?php

namespace backend\models\business;

use common\models\User;
use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "group_customer".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $code
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CustomerHasGroupCustomer[] $customerHasGroupCustomers
 * @property Customer[] $customers
 * @property User $user

 */
class GroupCustomer extends BaseModel
{

    public $customers_list = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'customers_list'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['created_at', 'updated_at', 'customers_list'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'default', 'value' => function ($model, $attribute) {
                return  time();
            }],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
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
            'name' => Yii::t('backend', 'Nombre'),
            'code' => Yii::t('backend', 'Código'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
            'customers_list' => Yii::t('backend', 'Clientes'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerHasGroupCustomers()
    {
        return $this->hasMany(CustomerHasGroupCustomer::className(), ['group_customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['id' => 'customer_id'])->viaTable('customer_has_group_customer', ['group_customer_id' => 'id']);
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
        return "/group-customer";
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
