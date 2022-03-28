<?php

namespace backend\models\nomenclators;

use Yii;

/**
 * This is the model class for table "country_lang".
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string $language
 *
 * @property Country $country
 */
class CountryLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'name', 'language'], 'required'],
            [['country_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 2],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => Yii::t('backend', 'País'),
            'name' => Yii::t('backend', 'Nombre'),
            'language' => Yii::t('backend', 'Idioma'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}
