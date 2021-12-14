<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BANNED = 0;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;


    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => '\yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['Created', 'LastUpdate'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['LastUpdate'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['Username', 'Authkey', 'Password', 'Email'], 'required'],
            [['PrivId','Enabled','IsVerified','IsOverriden','IsAdmin','IsLogin','IsAuthorized'], 'integer'],
            [['Created','LastUpdate','OverridDate'], 'safe'],
            [['Password', 'PasswordResetToken', 'Email'], 'string', 'max' => 255],
            [['Authkey'], 'string', 'max' => 32],
            [['MemberId','Username'], 'string', 'max' => 18],
            [['LastIP'], 'string', 'max' => 24],
            [['Username'], 'unique'],
            [['Email'], 'email'],
            [['Email'], 'unique'],
            [['PasswordResetToken'], 'unique']
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Username' => 'Username',
            'Authkey' => 'Authkey',
            'Password' => 'Password',
            'PasswordResetToken' => 'Password Reset Token',
            'Email' => 'Email',
            'PrivId' => 'Id Priv',
            'MemberId' => 'Employee ID',
            'Created' => 'Created',
            'LastUpdate' => 'Last Update',
            'LastIP' => 'Last Ip',
        ];
    }
	
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}
	
	
	public static function findIdentityByAccessToken($token,$type=null)
	{
		return static::findOne(['PasswordResetToken'=>$token]);
	}
	
	public static function findByUsername($username)
	{
		return static::findOne(['Username'=>$username,'Enabled' => 1]);
	}
	
	public static function findbyPasswordResetToken($token)
	{
		$expire = \Yii::$app->params['user.PasswordResetTokenExpire'];
		$parts = explode('_',$token);
		$timestamp = (int) end($parts);
		if ($timestamp + $expire < time()){
			//token expired
			return null;
		}
		return static::findOne(['PasswordResetToken' => $token]);
	}
	
	public static function findByVerificationToken($token) {
        return static::findOne([
            'VerificationToken' => $token,
        ]);
    }

	 public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.PasswordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
	
	public function getId()
	{
		return $this->getPrimaryKey();
	}
	
	public function getAuthKey()
	{
		return $this->Authkey;
	}
	
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey()==$authKey;
	}
	
	public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->Password);
    }
	
	public function setPassword($password)
    {
        $this->Password= Yii::$app->security->generatePasswordHash($password);
    }
	
	public function generateAuthKey()
    {
        $this->Authkey = Yii::$app->security->generateRandomString();
    }
	
	public function generatePasswordResetToken()
    {
        $this->PasswordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }
	
	public function generateEmailVerificationToken()
    {
        $this->VerificationToken = Yii::$app->security->generateRandomString() . '_' . time();
    }
	
	public function removePasswordResetToken()
	{
		$this->PasswordResetToken = null;
	}
	
	
	public function getPrivilege()
    {
        return $this->hasOne(UserPrivilege::className(), ['Id' => 'PrivId']);
    }
	
	
	public function getMember(){
		return $this->hasOne(Member::className(), ['MemberId' => 'MemberId']);
	}
	
         
    
}
