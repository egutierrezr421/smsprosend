<?php
namespace common\models;

use backend\models\business\AppAccess;
use backend\models\business\Customer;
use backend\models\business\GroupCustomer;
use backend\models\business\Recharge;
use backend\models\business\Sms;
use backend\models\business\SmsGroup;
use backend\models\settings\Setting;
use backend\models\UtilsConstants;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $auth_key_test
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property string $name
 * @property string $last_name
 * @property string $avatar
 * @property string $position
 * @property string $seniority
 * @property string $skills
 * @property string $personal_stuff
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 * @property float $balance
 * @property string $url_to_notify_delivery
 *
 * @property AppAccess[] $appAccesses
 * @property Customer[] $customers
 * @property GroupCustomer[] $groupCustomers
 * @property Recharge[] $recharges
 * @property Recharge[] $recharges0
 * @property Sms[] $sms
 * @property SmsGroup[] $smsGroups
 *
 */

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
	const IS_SUPERADMIN = 'superadmin';
	const SCENARIO_CREATE = 'create';
	const SCENARIO_UPDATE = 'update';
    const SCENARIO_CHANGE_PASSWORD = 'change_password';
    const SCENARIO_SING_UP = 'sing_up';
    const SCENARIO_RESET_PASSWORD = 'reset_password';

    const ROLE_SUPERADMIN = 'Superadmin';
    const ROLE_BASIC = 'Basic';

	public $fileAvatar;
	public $switch_status;
    public $role;

    /**
     * @var bool virtual attribute to check api test access
     */
    public $testAccess = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

	public function scenarios()
	{
		return [
			self::SCENARIO_CREATE => ['username', 'email', 'auth_key', 'auth_key_test', 'name', 'last_name','status','switch_status','password_hash','role','seniority', 'skills', 'personal_stuff','position','phone','balance','url_to_notify_delivery'],
			self::SCENARIO_UPDATE => ['username', 'email', 'auth_key', 'auth_key_test', 'name', 'last_name','status','switch_status','password_hash','role','seniority', 'skills', 'personal_stuff','position','phone','balance','url_to_notify_delivery'],
            self::SCENARIO_CHANGE_PASSWORD => [ 'auth_key','password_hash'],
            self::SCENARIO_SING_UP => ['username', 'email', 'auth_key', 'name', 'last_name','password_hash','phone','balance'],
            self::SCENARIO_RESET_PASSWORD => ['email', 'password_hash','auth_key','password_reset_token'],
        ];
	}

    /**
     * Save create and update times
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->updated_at = date('Y-m-d H:i:s');
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
        $customValidator = new RegexCustomValidator();
		$scenarios = $this->scenarios();
		return [
			//required
				[['username', 'email', 'auth_key', 'auth_key_test', 'name', 'last_name','status','switch_status','password_hash','role'], 'required', 'on' => self::SCENARIO_CREATE],
				[['username', 'email', 'auth_key', 'auth_key_test', 'name', 'last_name','status','switch_status','role'], 'required', 'on' => self::SCENARIO_UPDATE],
				[['username', 'email', 'auth_key', 'name', 'last_name','password_hash','phone'], 'required', 'on' => self::SCENARIO_SING_UP],
			//typed
				['username', 'trim'],
                ['username', 'match' , 'pattern'=> $customValidator->getPatternUsername(), 'message'=> $customValidator->getMessageUsername()],
                ['email', 'email'],
				[['status', 'switch_status'], 'integer'],
				[['fileAvatar','avatar','switch_status','created_at', 'updated_at'], 'safe'],
				[['fileAvatar'], 'file', 'extensions'=>'jpg, gif, png, svg, jpeg'],
                ['balance','number'],
                [['url_to_notify_delivery'],'url'],

            //format
				[['username', 'password_hash', 'password_reset_token', 'email', 'avatar', 'role', 'position','url_to_notify_delivery'], 'string', 'max' => 255],
				[['auth_key', 'auth_key_test'], 'string', 'max' => 32],
				[['name', 'last_name', 'phone'], 'string', 'max' => 50],
                [['seniority', 'skills', 'personal_stuff'], 'string'],
			//unique
				[['username'], 'unique'],
				[['email'], 'unique'],
				[['password_reset_token'], 'unique'],
			//default value
				['status', 'default', 'value' => self::STATUS_ACTIVE],
				['balance', 'default', 'value' => 0],
				['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => Yii::t('common','Nombre de usuario'),
			'auth_key' => Yii::t('common','Token de Acceso'),
			'auth_key_test' => Yii::t('common','Token de Acceso de Prueba'),
			'password_hash' => Yii::t('common','Contrase??a'),
			'password_reset_token' => 'Password Reset Token',
			'email' => Yii::t('common','Correo electr??nico'),
			'status' => Yii::t('common','Estado'),
			'switch_status' => Yii::t('common','Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creaci??n'),
            'updated_at' => Yii::t('backend', 'Fecha de actualizaci??n'),
			'name' => Yii::t('common','Nombre'),
			'last_name' => Yii::t('common','Apellidos'),
			'role' => Yii::t('common','Rol'),
			'avatar' => 'Avatar',
			'fileAvatar' => 'Avatar',
            'position' => Yii::t('common', 'Cargo'),
            'seniority' => Yii::t('common', 'Experiencia'),
            'skills' => Yii::t('common', 'Habilidades'),
            'personal_stuff' => Yii::t('common', 'Cosas personales'),
            'phone' => Yii::t('common', 'Tel??fono'),
            'balance' => Yii::t('common', 'Balance'),
            'url_to_notify_delivery' => Yii::t('common', 'Url para notificar mensajes'),
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppAccesses()
    {
        return $this->hasMany(AppAccess::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupCustomers()
    {
        return $this->hasMany(GroupCustomer::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecharges()
    {
        return $this->hasMany(Recharge::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecharges0()
    {
        return $this->hasMany(Recharge::className(), ['authorized_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSms()
    {
        return $this->hasMany(Sms::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmsGroups()
    {
        return $this->hasMany(SmsGroup::className(), ['user_id' => 'id']);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);

        if($user == null){
            $user = static::findOne(['auth_key_test' => $token, 'status' => self::STATUS_ACTIVE]);
            if($user !== null){
                $user->testAccess = true;
            }
        }

        return $user;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKeyTest()
    {
        return $this->auth_key_test;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = GlobalFunctions::generateRandomString();
        if($this->isNewRecord){
            $this->auth_key_test = GlobalFunctions::generateRandomString();
        }
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

	/**
	 * Get label with css to status of user
	 */
	public static function getStatusValue($value, $plainText=false)
	{
        if($plainText){
            if($value === self::STATUS_ACTIVE){
                return Yii::t('common','Activo');
            }else{
                return Yii::t('common','Inactivo');
            }
        }else{
            if($value === self::STATUS_ACTIVE)
                return Html::tag('span', Yii::t('common','Activo'), ['class'=>'label label-success']);
            else
                return Html::tag('span', Yii::t('common','Inactivo'), ['class'=>'label label-danger']);
        }
	}

	/**
	 * get path avatar of active user
	 * @return string $avatar_path
	 */
	public static function getUrlAvatarByActiveUser($is_frontend= false)
	{
		$user_active_id= \Yii::$app->getUser()->id;
		$model = User::findOne($user_active_id);
		if($model)
		{
		    $pre_path = ($is_frontend)? Yii::$app->urlManagerBackend->baseUrl.'/' : '';
			$path = $pre_path.''.Url::to('@web/uploads/avatars/');

			if($model->avatar==null || $model->avatar== '')
				$url = $path.'avatar_default.jpg';
			else
				$url = $path.''.$model->avatar;

			return $url;
		}
	}

	/**
	 * get path avatar of users
	 * @return string $avatar_path
	 */
	public static function getUrlAvatarByUserID($user_id=null)
	{
		$path = Url::to('@web/uploads/avatars/');

		if($user_id != null)
		{
			$model = User::findOne($user_id);
			if($model)
			{
				if($model->avatar == null || $model->avatar == '')
					$url = $path.'avatar_default.jpg';
				else
					$url = $path.''.$model->avatar;

				return $url;
			}
		}
		else
			return $url = $path.'avatar_default.jpg';
	}

	/**
	 * get name of active user
	 * @return string $name
	 */
	public static function getNameByActiveUser()
	{
		$user_active_id= \Yii::$app->getUser()->id;
		$model = User::findOne($user_active_id);
		if($model)
		{
			$name= $model->name;
			return $name;
		}
	}

	/**
	 * get full name of active user
	 * @return string $fullname
	 */
	public static function getFullNameByActiveUser()
	{
		$user_active_id= \Yii::$app->getUser()->id;
		$model = User::findOne($user_active_id);
		if($model)
		{
			$fullname= $model->name.' '.$model->last_name;
			return $fullname;
		}
	}

    /**
     * get full name of user
     * @return string
     */
    public static function getFullNameByUserId($user_id)
    {
        $model = self::findOne($user_id);

        if($model)
        {
            $fullname= $model->name.' '.$model->last_name;
            return $fullname;
        }
    }

	/**
	 * fetch stored image file name with complete path
	 * @return string
	 */
	public function getImageFile($is_frontend= false)
	{
	    if($is_frontend)
        {
            return isset($this->avatar) ? '../../backend/web/uploads/avatars/'.$this->avatar : null;
        }
        else
        {
            return isset($this->avatar) ? 'uploads/avatars/'.$this->avatar : null;
        }

	}

	/**
	 * fetch stored image url
	 * @return string
	 */
	public function getImageUrl($is_frontend= false)
	{
		// return a default image placeholder if your source avatar is not found
		$avatar = isset($this->avatar) ? $this->avatar : 'avatar_default.jpg';
        if($is_frontend)
        {
            return '../../backend/web/uploads/avatars/'.$avatar;
        }
        else
        {
            return 'uploads/avatars/'.$avatar;
        }

	}

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     * @throws \yii\base\Exception
     */
	public function uploadImage() {
		// get the uploaded file instance. for multiple file uploads
		// the following data will return an array (you may need to use
		// getInstances method)
		$image = UploadedFile::getInstance($this, 'fileAvatar');

		// if no image was uploaded abort the upload
		if (empty($image)) {
			return false;
		}

		// store the source file name
		// $this->filename = $image->name;
		$explode= explode('.',$image->name);
		$ext = end($explode);

		// generate a unique file name
		$this->avatar = Yii::$app->security->generateRandomString().".{$ext}";

		// the uploaded image instance
		return $image;
	}

	/**
	 * Process deletion of image
	 *
	 * @return boolean the status of deletion
	 */
	public function deleteImage($is_frontend= false) {
		$file = $this->getImageFile($is_frontend);

		// check if file exists on server
		if (empty($file) || !file_exists($file)) {
			return false;
		}

		// check if uploaded file can be deleted on server
        try{
            if (!unlink($file)) {
                return false;
            }
        }catch (\Exception $exception){
            Yii::info("Error deleting image on User: " . $file);
            Yii::info($exception->getMessage());
            return false;
        }

		// if deletion successful, reset your file attributes
		$this->avatar = null;

		return true;
	}

    /**
     * Get ArrayMapUsers list with by role.
     * @return array
     */
    public static function getUsersListByRole($role,$check_status=true)
    {
        $list = Yii::$app->authManager->getUserIdsByRole($role);

        $array_map = [];

        foreach ($list AS $user_id)
        {
            $query = self::find();

            if($check_status)
            {
                $query->where(['status' => self::STATUS_ACTIVE]);
            }

            $model_user = $query->andWhere(['id'=>$user_id])->one();

            $temp_name = $model_user->name.' '.$model_user->last_name;
            $array_map[$model_user->id] = $temp_name;
        }

        return $array_map;
    }

    /**
     * @param string $id user_id from audit_entry table
     * @return mixed|string
     */
    public static function userIdentifierCallback($id)
    {
        return self::getFullNameByUserId($id);
    }

    /**
     * @param string $identifier user_id from audit_entry table
     * @return mixed|string
     */
    public static function filterByUserIdentifierCallback($identifier)
    {
        return static::find()->select('id')
            ->where(['like', 'username', $identifier])
            ->orWhere(['like', 'email', $identifier])
            ->column();
    }

    /**
     * Get Users list.
     * @return array
     */
    public static function getSelectMap($check_status=true)
    {
        $array_map = [];

        $query = self::find();

        if($check_status)
        {
            $query->where(['status' => self::STATUS_ACTIVE]);
        }

        $models = $query->all();

        if(count($models)>0)
        {
            foreach ($models AS $index => $model)
            {
                $temp_name = $model->name.' '.$model->last_name;
                $array_map[$model->id] = $temp_name;
            }
        }

        return $array_map;
    }

    /**
     * Returns an array using all data for fetch at api endpoints
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getModelAsJson()
    {
        return [
            'id' => $this->id,
            'username'=>$this->username,
            'authKey'=>$this->auth_key,
            'name' => isset($this->name) && !empty($this->name)? $this->name : "",
            'lastName' => isset($this->last_name) && !empty($this->last_name)? $this->last_name : "",
            'email' => isset($this->email) && !empty($this->email)? $this->email : "",
            'status' => self::getStatusValue($this->status, true),
            'avatar' => Yii::$app->urlManager->getBaseUrl() . "/" . $this->getImageUrl(),
            'phone' => isset($this->phone) && !empty($this->phone)? $this->phone : "",
            'balance' =>isset($this->balance) && !empty($this->balance)? $this->balance : "",
            'url_to_notify_delivery' =>isset($this->url_to_notify_delivery) && !empty($this->url_to_notify_delivery)? $this->url_to_notify_delivery : "",
        ];
    }

    /**
     * @return bool
     */
    public static function isSuperAdmin() {
        return GlobalFunctions::getRol() === User::ROLE_SUPERADMIN;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    public static function sendEmailApprovAccount($user)
    {
        $subject = Yii::t('backend','Cuenta verificada en {site_name}',['site_name'=> Setting::getName()]);

        $mailer = Yii::$app->mail->compose(['html' => 'approv-account-html'], ['user' => $user])
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
     * @param int $user_id
     * @param int $action_type
     * @param float $value
     */
    public static function updateBalance($user_id, $action_type, $value) {
        $model = self::findOne($user_id);
        $model->scenario = self::SCENARIO_UPDATE;

        if ($model !== null && GlobalFunctions::getRol($user_id) !== User::ROLE_SUPERADMIN) {
            if($action_type === UtilsConstants::UPDATE_NUMBER_PLUS) {
                $model->balance += $value;
            } elseif($action_type === UtilsConstants::UPDATE_NUMBER_MINUS) {
                if ($value >= $model->balance) {
                    $model->balance = 0;
                } else {
                    $model->balance -= $value;
                }
            } elseif($action_type === UtilsConstants::UPDATE_NUMBER_SET) {
                $model->balance = $value;
            }

            $model->save(false);
        }
    }

    public static function resendQvatelNotification($user_id, $sms) {
        $user = self::findOne($user_id);
        if($user !== null) {
            if(isset($user->url_to_notify_delivery) && !empty($user->url_to_notify_delivery)) {

            }
        }

    }

}
