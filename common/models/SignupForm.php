<?php
namespace common\models;

use backend\models\settings\Setting;
use common\models\GlobalFunctions;
use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $lastname;
    public $phone;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username','name','lastname'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['name','lastname','phone'], 'string', 'max' => 50],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User'],

            ['password', 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common','Nombre de usuario'),
            'password' => Yii::t('common','Contraseña'),
            'email' => Yii::t('common','Correo electrónico'),
            'name' => Yii::t('common','Nombre'),
            'lastname' => Yii::t('common','Apellidos'),
            'phone' => Yii::t('common','Teléfono'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $user = new User();
        $user->scenario = User::SCENARIO_SING_UP;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->last_name = $this->lastname;
        $user->status = User::STATUS_INACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $role_selected = User::ROLE_BASIC;
        $user->phone = $this->phone;

        if($user->save())
        {
            $this->sendEmail($user);
            $this->sendEmailAdmin($user);
            $role = \Yii::$app->authManager->getRole($role_selected);
            \Yii::$app->authManager->revokeAll($user->id);
            \Yii::$app->authManager->assign($role, $user->id);

            return $user;
        }
        else
        {
            return $user->getErrors();
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        $subject = Yii::t('backend','Registro de cuenta en {site_name}',['site_name'=> Setting::getName()]);

        $mailer = Yii::$app->mail->compose(['html' => 'signup-html'], ['user' => $user])
            ->setTo($this->email)
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
    protected function sendEmailAdmin($user)
    {
        $subject = Yii::t('backend','Nuevo usuario registrado en {site_name}',['site_name'=> Setting::getName()]);
        $superadmin_email = User::findOne(1)->email;

        $mailer = Yii::$app->mail->compose(['html' => 'signup-notify-admin-html'], ['user' => $user])
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
