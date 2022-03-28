<?php

namespace backend\models\business;

use Yii;
use backend\models\BaseModel;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "customer_has_group_customer".
 *
 * @property int $customer_id
 * @property int $group_customer_id
 *
 * @property Customer $customer
 * @property GroupCustomer $groupCustomer

 */
class CustomerHasGroupCustomer extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_has_group_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'group_customer_id'], 'required'],
            [['customer_id', 'group_customer_id'], 'integer'],
            [['customer_id', 'group_customer_id'], 'unique', 'targetAttribute' => ['customer_id', 'group_customer_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['group_customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupCustomer::className(), 'targetAttribute' => ['group_customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => Yii::t('backend', 'Customer ID'),
            'group_customer_id' => Yii::t('backend', 'Group Customer ID'),
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
    public function getGroupCustomer()
    {
        return $this->hasOne(GroupCustomer::className(), ['id' => 'group_customer_id']);
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
        return "/customer-has-group-customer";
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
     * @param $customer_id
     * @param $group_customer_id
     * @return bool
     */
    public static function addRelation($customer_id, $group_customer_id)
    {
        $model= new self();
        $model->group_customer_id = $group_customer_id;
        $model->customer_id = $customer_id;
        $model->save();
    }

    /**
     * @param $customer_id
     * @param $group_customer_id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteRelation($customer_id, $group_customer_id)
    {
        $model= self::find()->where(['group_customer_id' => $group_customer_id, 'customer_id' => $customer_id])->one();

        $model->delete();
    }

    /**
     * @param $group_customer_id
     * @param bool $as_array
     * @return array|CustomerHasGroupCustomer[]|\yii\db\ActiveRecord[]
     */
    public static function getCustomersByGroupId($group_customer_id,$as_array = true)
    {
        $query= self::find()
            ->where(['group_customer_id' => $group_customer_id]);

        if($as_array)
        {
            $query->asArray();
        }

        $model = $query->all();

        return $model;
    }

    /**
     * $old_items_assigned elementos asociados antes de actualizar
     * $field es el campo que almacena la relacion
     * $param_to_check es el nombre del atributo a utilizar en el arrayMap
     *
     * @param $model
     * @param $old_items_assigned
     * @param $field
     * @param $param_to_check
     */
    public static function updateRelation($model, $old_items_assigned, $field, $param_to_check)
    {
        if (!empty($model->$field))
            $new_item_assigned = $model->$field;
        else
            $new_item_assigned = [];

        $toRemove = array_diff(ArrayHelper::map($old_items_assigned, $param_to_check, $param_to_check), $new_item_assigned);
        $toAdd = array_diff($new_item_assigned, ArrayHelper::map($old_items_assigned, $param_to_check, $param_to_check));

        if(isset($toAdd) && !empty($toAdd))
        {
            foreach ($toAdd as $item)
            {
                $result = self::addRelation($item,$model->id);
            }
        }

        if(isset($toRemove) && !empty($toRemove))
        {
            foreach ($toRemove as $item)
            {
                $result = self::deleteRelation($item,$model->id);
            }
        }
    }

    /**
     * Función que retorna un string separando por comas
     *
     * @param $id
     * @return string
     */
    public static function getCustomersStringByGroupId($id)
    {
        $items = self::find()->where(['group_customer_id'=>$id])->one();
        $result = '';

        if($items !== null)
        {
            $relations = self::getCustomersByGroupId($id,false);
            $array = [];
            foreach ($relations AS $key => $value)
            {
                $array[] = $value->customer->name;
            }

            $result = implode(', ',$array);
        }

        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getItemsAsignedByGroupId($id)
    {
        $items_assigned = self::getCustomersByGroupId($id);

        $items_ids= [];
        foreach ($items_assigned as $value)
        {
            $items_ids[]= $value['group_customer_id'];
        }

        return $items_ids;
    }
}
