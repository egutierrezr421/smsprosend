<?php

namespace backend\models\business;

use backend\models\nomenclators\PaymentMethod;
use backend\models\settings\Setting;
use backend\models\UtilsConstants;
use common\models\User;
use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;

/**
 * This is the model class for table "recharge".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $authorized_by
 * @property int|null $payment_method_id
 * @property float|null $amount
 * @property float|null $commission
 * @property float|null $total_to_pay
 * @property string|null $source_account
 * @property string|null $target_account
 * @property int $paid
 * @property int $status
 * @property string|null $rejected_note
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PaymentMethod $paymentMethod
 * @property User $user
 * @property User $authorizedBy

 */
class Recharge extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recharge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'commission', 'total_to_pay', 'source_account', 'payment_method_id'], 'required'],
            [['user_id', 'authorized_by', 'payment_method_id', 'paid', 'status'], 'integer'],
            [['amount', 'commission', 'total_to_pay'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['rejected_note',], 'string'],
            [['source_account', 'target_account'], 'string', 'max' => 255],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
            ['status', 'default', 'value' => UtilsConstants::RECHARGE_STATUS_PENDING],
            ['paid', 'default', 'value' => 0],
            [['payment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethod::className(), 'targetAttribute' => ['payment_method_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['authorized_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['authorized_by' => 'id']],
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
            'authorized_by' => Yii::t('backend', 'Autorizado por'),
            'payment_method_id' => Yii::t('backend', '¿Cómo nos pagarás?'),
            'amount' => Yii::t('backend', 'Fondos a acreditar'),
            'commission' => Yii::t('backend', 'Comisión'),
            'total_to_pay' => Yii::t('backend', 'Total a pagar'),
            'source_account' => Yii::t('backend', 'Cuenta que envía el pago'),
            'target_account' => Yii::t('backend', 'Cuenta a pagar'),
            'paid' => Yii::t('backend', 'Pago realizado'),
            'status' => Yii::t('backend', 'Estado'),
            'rejected_note' => Yii::t('backend', 'Motivo del rechazo'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::className(), ['id' => 'payment_method_id']);
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
    public function getAuthorizedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'authorized_by']);
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
        return "/recharge";
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

    public static function getTotalAmountByStatus($status, $user_id = null) {
        $query = self::find();

        if($user_id !== null) {
            $query->andWhere(['user_id' => $user_id]);
        } else {
            if(!User::isSuperAdmin()) {
                $query->andWhere(['user_id' => Yii::$app->user->id]);
            }
        }

        $query->andWhere(['status' => $status]);

        $result = $query->sum('amount');

        return $result?? 0;
    }

    public static function getTotalConsumed($user_id = null) {
        $query = Sms::find()
            ->leftJoin('user','sms.user_id = user.id');

        if($user_id !== null) {
            $query->andWhere(['sms.user_id' => $user_id]);
        } else {
            if(!User::isSuperAdmin()) {
                $query->andWhere(['sms.user_id' =>Yii::$app->user->id]);
            }
        }

        $result = $query->sum('sms.cost');

        return $result?? 0;
    }

    /**
     * @param null $user_id
     * @return float|int|mixed
     */
    public static function getAvailableBalance($user_id = null) {

        if($user_id !== null)
        {
            $model = User::find()->andWhere(['id' => $user_id])->one();

            if($model !== null) {
                return $model->balance?? 0;
            }

        } else {
            if(!User::isSuperAdmin()) {
                $model = User::find()->andWhere(['id' => Yii::$app->user->id])->one();

                if($model !== null) {
                    return $model->balance?? 0;
                }
            }
            else
            {
                $sum = User::find()->sum('balance');
                return $sum?? 0;
            }
        }

        return 0;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public static function sendEmailApprov($user)
    {
        $subject = Yii::t('backend','Recarga aprobada en {site_name}',['site_name'=> Setting::getName()]);

        $mailer = Yii::$app->mail->compose(['html' => 'approv-recharge-html'], ['user' => $user])
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
    public static function sendEmailAdmin($recharge_id)
    {
        $subject = Yii::t('backend','Nueva solicitud de recarga en {site_name}',['site_name'=> Setting::getName()]);
        $superadmin_email = User::findOne(1)->email;

        $mailer = Yii::$app->mail->compose(['html' => 'recharge-notify-admin-html'], ['recharge_id' => $recharge_id])
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
