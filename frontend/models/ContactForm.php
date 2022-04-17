<?php

namespace frontend\models;

use backend\models\settings\Setting;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $message;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'message'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'phone' => 'Teléfono',
            'message' => 'Mensaje',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        $subject = Yii::t('backend','Mensaje desde formulario de contacto de {site-name}',['site-name' => Setting::getName()]);

        $model = ['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone, 'message' => $this->message];
        return Yii::$app->mail->compose(['html' => 'contact-form-html'],['model' => $model])
            ->setTo($email)
            ->setFrom([Setting::getEmail() => Setting::getName()])
            ->setSubject($subject)
            ->send();

    }
}
