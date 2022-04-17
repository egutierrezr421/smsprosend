<?php

namespace backend\models\settings;

use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "landing".
 *
 * @property int $id
 * @property string|null $welcome_text
 * @property string|null $about_short_text
 * @property string|null $about_text
 * @property string|null $app_short_text
 * @property string|null $app_text
 * @property string|null $app_link
 * @property string|null $facebook_url
 * @property string|null $instagram_url
 * @property string|null $linkedin_url
 * @property string|null $twitter_url
 * @property string|null $privacy_text
 * @property string|null $service_recharge_mobile_text
 * @property string|null $service_recharge_nauta_text
 * @property string|null $service_call_text
 * @property string|null $service_sms_text
 * @property string|null $service_videocall_text
 * @property string|null $service_videocall3d_text
 * @property string|null $service_2fa_text
 * @property string $created_at
 * @property string $updated_at

 */
class Landing extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'landing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['welcome_text', 'about_short_text', 'about_text', 'app_short_text', 'app_text', 'privacy_text', 'service_recharge_mobile_text', 'service_recharge_nauta_text', 'service_call_text', 'service_sms_text', 'service_videocall_text', 'service_videocall3d_text', 'service_2fa_text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['app_link', 'facebook_url', 'instagram_url', 'linkedin_url', 'twitter_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'welcome_text' => Yii::t('backend', 'Texto bienvenida'),
            'about_short_text' => Yii::t('backend', 'Texto corto Acerca de'),
            'about_text' => Yii::t('backend', 'Texto completo Acerca de'),
            'app_short_text' => Yii::t('backend', 'Texto corto App'),
            'app_text' => Yii::t('backend', 'Texto completo App'),
            'app_link' => Yii::t('backend', 'Vínculo de App'),
            'facebook_url' => Yii::t('backend', 'Url facebook'),
            'instagram_url' => Yii::t('backend', 'Url instagram'),
            'linkedin_url' => Yii::t('backend', 'Url linkedin'),
            'twitter_url' => Yii::t('backend', 'Url twitter'),
            'privacy_text' => Yii::t('backend', 'Política de privacidad'),
            'service_recharge_mobile_text' => Yii::t('backend', 'Texto recarga movil'),
            'service_recharge_nauta_text' => Yii::t('backend', 'Texto recarga nauta'),
            'service_call_text' => Yii::t('backend', 'Texto llamadas de voz'),
            'service_sms_text' => Yii::t('backend', 'Texto mensajes'),
            'service_videocall_text' => Yii::t('backend', 'Texto videollamadas'),
            'service_videocall3d_text' => Yii::t('backend', 'Texto videollamadas 3D'),
            'service_2fa_text' => Yii::t('backend', 'Texto 2FA'),
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
        return "/landing";
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

    public static function getIdLanding() {
        $id = Setting::find()->one()->id;

        return $id?? 1;
    }
}
