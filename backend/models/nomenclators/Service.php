<?php

namespace backend\models\nomenclators;

use backend\models\UtilsConstants;
use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property float $price_general
 * @property int $status
 * @property string $created_at
 * @property string $updated_at

 */
class Service extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'price_general'], 'required'],
            [['price_general'], 'number'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['code','unique'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Nombre'),
            'code' => Yii::t('backend', 'Código'),
            'price_general' => Yii::t('backend', 'Precio general'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
        ];
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
        return "/service";
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

    public static function calculatePrice($country_id, $service_id, $quantity) {

        $country = Country::find()->where(['id' => $country_id,'status' => 1])->one();
        if($country !== null) {
            $service = Service::find()->where(['id' => $service_id,'status'=>1])->one();

            if($service !== null) {
                if($service->code == UtilsConstants::SERVICES_CODE_SMS) {
                    return $quantity*$country->sms_price;
                } else {
                    return $quantity*$service->price_general;
                }
            }
        }

        return false;
    }
}
