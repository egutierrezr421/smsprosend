<?php

namespace backend\models\business;

use backend\models\nomenclators\RechargeEtecsaType;
use backend\models\settings\Setting;
use backend\models\UtilsConstants;
use common\models\User;
use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "recharge_etecsa".
 *
 * @property int $id
 * @property int $recharge_etecsa_type_id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property int $operator
 * @property int $quantity
 * @property int $type
 * @property float $total_cost
 * @property string|null $email
 * @property string|null $phone
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Customer $customer
 * @property RechargeEtecsaType $rechargeEtecsaType
 * @property User $user

 */
class RechargeEtecsa extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recharge_etecsa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recharge_etecsa_type_id', 'operator', 'quantity', 'type', 'total_cost','user_id','status'], 'required'],
            [['recharge_etecsa_type_id', 'user_id', 'customer_id', 'operator', 'quantity', 'type', 'status'], 'integer'],
            [['total_cost'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'phone'], 'string', 'max' => 255],
            ['status', 'default', 'value' => UtilsConstants::RECHARGE_ETECSA_STATUS_PENDING],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['recharge_etecsa_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RechargeEtecsaType::className(), 'targetAttribute' => ['recharge_etecsa_type_id' => 'id']],
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
            'recharge_etecsa_type_id' => Yii::t('backend', 'Oferta de recarga'),
            'user_id' => Yii::t('backend', 'Usuario'),
            'customer_id' => Yii::t('backend', 'Contacto'),
            'operator' => Yii::t('backend', 'Operador'),
            'quantity' => Yii::t('backend', 'Cantidad de recargas'),
            'type' => Yii::t('backend', 'Tipo'),
            'total_cost' => Yii::t('backend', 'Costo total'),
            'email' => Yii::t('backend', 'Cuenta nauta a recargar'),
            'phone' => Yii::t('backend', 'Teléfono a recargar'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
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
    public function getRechargeEtecsaType()
    {
        return $this->hasOne(RechargeEtecsaType::className(), ['id' => 'recharge_etecsa_type_id']);
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
        return "/recharge-etecsa";
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
     * Sends confirmation email to user
     * @param RechargeEtecsa $model
     * @return bool whether the email was sent
     */
    public static function sendEmailApprov($model)
    {
        $user = $model->user;
        $subject = Yii::t('backend','Recarga completada desde {site_name}',['site_name'=> Setting::getName()]);

        $mailer = Yii::$app->mail->compose(['html' => 'approv-recharge-etecsa-html'], ['user' => $user, 'model' => $model])
            ->setTo($user->email)
            ->setFrom([Setting::getEmail() => Setting::getName()])
            ->setSubject($subject);

        try
        {
            if($mailer->send())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch (\Swift_TransportException $e)
        {
            return false;
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public static function sendEmailAdmin($recharge_id, $is_frontend = false)
    {
        $subject = Yii::t('backend','Nueva solicitud de recarga ETECSA en {site_name}',['site_name'=> Setting::getName()]);
        $superadmin_email = User::findOne(1)->email;

        $mailer = Yii::$app->mail->compose(['html' => 'recharge-etecsa-notify-admin-html'], ['recharge_id' => $recharge_id,'is_frontend' => $is_frontend])
            ->setTo($superadmin_email)
            ->setFrom([Setting::getEmail() => Setting::getName()])
            ->setSubject($subject);

        try
        {
            if($mailer->send())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch (\Swift_TransportException $e)
        {
            return false;
        }
    }
}
