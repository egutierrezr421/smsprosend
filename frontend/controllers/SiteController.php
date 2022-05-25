<?php

namespace frontend\controllers;

use backend\models\nomenclators\Service;
use backend\models\settings\Landing;
use common\components\Notification;
use common\models\GlobalFunctions;
use common\models\PasswordResetRequest;
use common\models\ResetPassword;
use common\models\User;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\ResetPasswordForm;
use common\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'client-area', 'client-new-message','client-statistic','client-contacts'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','client-area', 'client-new-message','client-statistic','client-contacts'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('client-area');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('client-area');
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $email_to_send = User::find()->where(['username' => 'superadmin'])->one()->email;
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($model->sendEmail($email_to_send)) {
                $result = ['success' => true,'message'=> 'Gracias por contactarnos. Le responderemos lo más pronto posible.'];
            } else {
                $result =  ['success' => false,'message'=> 'Ha ocurrido un error enviando sus datos'];
            }
        } else {
            $result =  ['success' => false,'message'=> 'Ha ocurrido un error enviando sus datos', 'errors' => $model->getErrors()];
        }

        return $this->renderAjax('contact-form',['result' => $result]);
    }

    /**
     * Displays privacy page.
     *
     * @return mixed
     */
    public function actionPrivacy()
    {
        $landing = Landing::find()->select(['privacy_text'])->one();

        return $this->render('privacy', ['information' => $landing->privacy_text]);
    }

    /**
     * Displays app page.
     *
     * @return mixed
     */
    public function actionAppPage()
    {
        $landing = Landing::find()->select(['app_text','app_link'])->one();

        return $this->render('app-page', ['landing' => $landing]);
    }

    /**
     * Displays privacy page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $landing = Landing::find()->select(['about_text'])->one();

        return $this->render('about', ['text' => $landing->about_text]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()))
        {
            if ($user = $model->signup())
            {
                if(isset($user->id) && !empty($user->id))
                {
                    GlobalFunctions::addFlashMessage('success',Yii::t('backend','Usuario registrado correctamente pendiente de activación. Espere un email para poder acceder.'));
                    Notification::notify(Notification::KEY_NEW_USER_REGISTRED, 1, $user->id);

                    if (Yii::$app->getUser()->login($user)) {
                        return $this->redirect('confirm-signup');
                    }
                }
                else
                {
                    GlobalFunctions::addFlashMessage('danger', Yii::t('backend', 'Error registrando el usuario'));
                    $model->addErrors($user);
                }
            }
            else
            {
                GlobalFunctions::addFlashMessage('danger', Yii::t('backend', 'Error registrando el usuario'));
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail(true)) {
                GlobalFunctions::addFlashMessage('success',Yii::t('backend','Revise su correo electrónico para obtener más instrucciones para restaurar la contraseña'));
                return $this->redirect('info-reset-password');
            } else {

                GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Ha ocurrido un error. No se ha podido establecer la conexión con el servidor de correo'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()))
        {

            if($model->resetPassword())
            {
                GlobalFunctions::addFlashMessage('success',Yii::t('backend','Nueva contraseña guardada correctamente'));

                return $this->redirect('client-area');
            }
            else {

                GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error actualizando la contraseña'));
            }

        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * @param integer $type
     */
    public function actionPageService($type) {

        $landing = Landing::find()->one();
        $type = (int) $type;

        if($type === 1) {
            $title = 'Recarga móvil';
            $top_separator_url = '/images/separator-pages/top-blue.png';
            $bottom_separator_url = '/images/separator-pages/bottom-green.png';
            $content_image_url = '/images/content-pages/recharge-movile.png';
            $content_image_url_right = '/images/content-pages/recharge-movile-right.png';
            $text = $landing->service_recharge_mobile_text;
            $btn_label = 'Recargar ahora';
        } elseif($type === 2){
            $title = 'Recarga nauta';
            $top_separator_url = '/images/separator-pages/top-green.png';
            $bottom_separator_url = '/images/separator-pages/bottom-blue.png';
            $content_image_url = '/images/content-pages/recharge-nauta.png';
            $content_image_url_right = '/images/content-pages/recharge-nauta-right.png';
            $text = $landing->service_recharge_nauta_text;
            $btn_label = 'Recargar ahora';
        } elseif($type === 3){
            $title = 'Llamadas';
            $top_separator_url = '/images/separator-pages/top-orange.png';
            $bottom_separator_url = '/images/separator-pages/bottom-green.png';
            $content_image_url = '/images/content-pages/call.png';
            $content_image_url_right = '/images/content-pages/call-right.png';
            $text = $landing->service_call_text;
            $btn_label = 'Llamar ahora';
        } elseif($type === 4){
            $title = 'Mensajes';
            $top_separator_url = '/images/separator-pages/top-green.png';
            $bottom_separator_url = '/images/separator-pages/bottom-blue.png';
            $content_image_url = '/images/content-pages/sms.png';
            $content_image_url_right = '/images/content-pages/sms-right.png';
            $text = $landing->service_sms_text;
            $btn_label = 'Enviar ahora';
        } elseif($type === 5){
            $title = 'Videollamadas';
            $top_separator_url = '/images/separator-pages/top-blue.png';
            $bottom_separator_url = '/images/separator-pages/bottom-green.png';
            $content_image_url = '/images/content-pages/videocall.png';
            $content_image_url_right = '/images/content-pages/videocall-right.png';
            $text = $landing->service_videocall_text;
            $btn_label = 'Llamar ahora';
        } elseif($type === 6){
            $title = 'Videollamadas 3D';
            $top_separator_url = '/images/separator-pages/top-orange.png';
            $bottom_separator_url = '/images/separator-pages/bottom-blue.png';
            $content_image_url = '/images/content-pages/videocall3d.png';
            $content_image_url_right = '/images/content-pages/videocall3d-right.png';
            $text = $landing->service_videocall3d_text;
            $btn_label = 'Llamar ahora';
        } elseif($type === 7){
            $title = '2FA';
            $top_separator_url = '/images/separator-pages/top-orange.png';
            $bottom_separator_url = '/images/separator-pages/bottom-green.png';
            $content_image_url = '/images/content-pages/2fa.png';
            $content_image_url_right = '/images/content-pages/2fa-right.png';
            $text = $landing->service_2fa_text;
            $btn_label = 'Autenticarse';
        } else {
            throw new NotFoundHttpException(Yii::t('backend','La página solicitada no existe'));
        }


        return $this->render('page-service', [
            'title' => $title,
            'top_separator_url' => $top_separator_url,
            'bottom_separator_url' => $bottom_separator_url,
            'content_image_url' => $content_image_url,
            'content_image_url_right' => $content_image_url_right,
            'text' => $text,
            'btn_label' => $btn_label,
        ]);
    }

    public function actionCalculate($country_id, $service_id, $quantity) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $calculate = Service::calculatePrice($country_id, $service_id, $quantity);

        if($calculate) {
            return ['success' => true, 'price' => $calculate];
        } else {
            return ['success' => false];
        }
    }

    /**
     * Displays app page.
     *
     * @return mixed
     */
    public function actionClientArea()
    {
        $landing = Landing::find()->one();

        return $this->render('client-area', ['landing' => $landing]);
    }

    /**
     * Displays confirm-signup page.
     *
     * @return mixed
     */
    public function actionConfirmSignup()
    {
        return $this->render('confirm-signup');
    }

    /**
     * Displays info-reset-password page.
     *
     * @return mixed
     */
    public function actionInfoResetPassword()
    {
        return $this->render('info-reset');
    }

    /**
     * Displays app page.
     *
     * @return mixed
     */
    public function actionClientNewMessage()
    {
        $landing = Landing::find()->one();

        return $this->render('client-new-message', ['landing' => $landing]);
    }

    /**
     * Displays app page.
     *
     * @return mixed
     */
    public function actionClientStatistic()
    {
        $landing = Landing::find()->one();

        return $this->render('client-statistic', ['landing' => $landing]);
    }

}
