<?php

namespace backend\models\business;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "group_customer_has_sms_group".
 *
 * @property int $group_customer_id
 * @property int $sms_group_id
 *
 * @property GroupCustomer $groupCustomer
 * @property SmsGroup $smsGroup
 */
class GroupCustomerHasSmsGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_customer_has_sms_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_customer_id', 'sms_group_id'], 'required'],
            [['group_customer_id', 'sms_group_id'], 'integer'],
            [['group_customer_id', 'sms_group_id'], 'unique', 'targetAttribute' => ['group_customer_id', 'sms_group_id']],
            [['group_customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupCustomer::className(), 'targetAttribute' => ['group_customer_id' => 'id']],
            [['sms_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SmsGroup::className(), 'targetAttribute' => ['sms_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group_customer_id' => Yii::t('backend', 'Group Customer ID'),
            'sms_group_id' => Yii::t('backend', 'Sms Group ID'),
        ];
    }

    /**
     * Gets query for [[GroupCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroupCustomer()
    {
        return $this->hasOne(GroupCustomer::className(), ['id' => 'group_customer_id']);
    }

    /**
     * Gets query for [[SmsGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSmsGroup()
    {
        return $this->hasOne(SmsGroup::className(), ['id' => 'sms_group_id']);
    }

    /**
     * @param $sms_group_id
     * @param $group_customer_id
     * @return bool
     */
    public static function addRelation($group_customer_id, $sms_group_id)
    {
        $model= new self();
        $model->group_customer_id = $group_customer_id;
        $model->sms_group_id = $sms_group_id;
        $model->save();
    }

    /**
     * @param $sms_group_id
     * @param $group_customer_id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteRelation($group_customer_id, $sms_group_id)
    {
        $model= self::find()->where(['group_customer_id' => $group_customer_id, 'sms_group_id' => $sms_group_id])->one();

        $model->delete();
    }

    /**
     * @param $sms_group_id
     * @param bool $as_array
     * @return array|CustomerHasGroupCustomer[]|\yii\db\ActiveRecord[]
     */
    public static function getGroupCustomersBySmsGroupId($sms_group_id,$as_array = true)
    {
        $query= self::find()
            ->where(['sms_group_id' => $sms_group_id]);

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
    public static function getGroupCustomersStringBySmsGroupId($id)
    {
        $items = self::find()->where(['sms_group_id'=>$id])->one();
        $result = '';

        if($items !== null)
        {
            $relations = self::getGroupCustomersBySmsGroupId($id,false);
            $array = [];
            foreach ($relations AS $key => $value)
            {
                $array[] = $value->groupCustomer->name;
            }

            $result = implode(', ',$array);
        }

        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getItemsAsignedBySmsGroupId($id)
    {
        $items_assigned = self::getGroupCustomersBySmsGroupId($id);

        $items_ids= [];
        foreach ($items_assigned as $value)
        {
            $items_ids[]= $value['group_customer_id'];
        }

        return $items_ids;
    }
}
