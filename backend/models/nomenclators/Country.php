<?php

namespace backend\models\nomenclators;

use backend\models\business\Customer;
use backend\models\business\Sms;
use common\models\GlobalFunctions;
use Yii;
use backend\models\BaseModel;
use dosamigos\translateable\TranslateableBehavior;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property integer $phone_code
 * @property int $status
 * @property float $sms_price
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CountryLang[] $countryLangs
 * @property Customer[] $customers
 * @property Sms[] $smses

 */
class Country extends BaseModel
{

    public function behaviors()
    {
        return [
            'trans' => [ // name it the way you want
                'class' => TranslateableBehavior::className(),
                // in case you named your relation differently, you can setup its relation name attribute
                'relation' => 'countryLangs',
                // in case you named the language column differently on your translation schema
                //'languageField' => 'language',
                'translationAttributes' => [
                    'name'
                ],
                // use english as fallback for all languages when no translation is available
                'fallbackLanguage' => 'es',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','code'], 'required'],
            [['status','phone_code'], 'integer'],
            [['created_at', 'updated_at','sms_price'], 'safe'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('backend', 'Nombre'),
            'code' => Yii::t('backend', 'Código'),
            'phone_code' => Yii::t('backend', 'Código telefónico'),
            'sms_price' => Yii::t('backend', 'Precio SMS'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'code' => Yii::t('backend', 'Se refiere al código de alfa-2 de la ISO 3166-1, asociado a cada país'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmses()
    {
        return $this->hasMany(Sms::className(), ['receptor_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryLangs()
    {
        return $this->hasMany(CountryLang::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['country_id' => 'id']);
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
        return "/country";
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
     * @param boolean $getcode //poner en true para usar como id del select el code en vez del id
     * @return array
     */
    public static function getSelectMap($check_status = true, $show_code_id = false)
    {
        if($check_status)
        {
            $options = ['status' => self::STATUS_ACTIVE];
            $models = self::find()
                ->select(['country.id','country.code', 'country.phone_code','country_lang.name'])
                ->innerJoin('country_lang', 'country_lang.country_id = country.id AND country_lang.language=\''.Yii::$app->language.'\'')
                ->where($options)
                ->asArray()
                ->all();
        }
        else
        {
            $models = self::find()
                ->select(['country.id','country.code', 'country.phone_code','country_lang.name'])
                ->innerJoin('country_lang', 'country_lang.country_id = country.id AND country_lang.language=\''.Yii::$app->language.'\'')
                ->asArray()
                ->all();
        }

        $array_map = [];

        if(count($models)>0)
        {
            foreach ($models AS $index => $model)
            {
                $temp_name = '+'.$model['phone_code'].' - '.$model['name'];

                if($show_code_id)
                {
                    $array_map[$model['code']] = $temp_name;
                }
                else
                {
                    $array_map[$model['id']] = $temp_name;
                }
            }
        }

        return $array_map;
    }

    /**
     * Function to get code - name of Country model
     *
     * @param integer $id
     * @return string
     */
    public static function getCodeAndName($id)
    {
        $model = self::findOne($id);
        if($model)
        {
            return $model->code.' - '.$model->name;
        }
        else
        {
            return '';
        }
    }

    /**
     * Function to get name by code
     *
     * @param integer $id
     * @return string
     */
    public static function getNameByCode($code)
    {
        $model = self::find()->where(['code'=>$code])->one();

        if($model !== null)
        {
            return $model->name;
        }
        else
        {
            return '';
        }
    }

    public function fields()
    {
        $result = parent::fields();

        unset($result['status']);
        unset($result['created_at']);
        unset($result['updated_at']);

        $result['name'] = function ($model) {
            return $model->name;
        };

        return $result;
    }

}
