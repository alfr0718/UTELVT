<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\base\Model;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $Auth_key
 * @property int $Status
 * @property int $tipo_usuario
 * @property string $Created_at
 * @property string $Updated_at
 * @property string|null $Temporalpassword
 * @property string|null $Tempralpasswordtime
 *
 * @property Personaldata $username0
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    private $_user = false;

    //public $currentPassword;
    //public $newPassword;
    //public $confirmPassword;
    //public $temporalpassword;
    //public $tempralpasswordtime;
    //public $_roleNames = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'Auth_key', 'Created_at'], 'required'],
            [['Status', 'tipo_usuario'], 'integer'],
            [['Created_at', 'Updated_at', 'Tempralpasswordtime'], 'safe'],
            [['username'], 'string', 'max' => 15],
            [['password', 'Temporalpassword'], 'string', 'max' => 255],
            [['Auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['username'], 'exist', 'skipOnError' => true, 'targetClass' => Personaldata::class, 'targetAttribute' => ['username' => 'Ci']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'Auth_key' => 'Auth Key',
            'Status' => 'Status',
            'tipo_usuario' => 'Tipo Usuario',
            'Created_at' => 'Created At',
            'Updated_at' => 'Updated At',
            'Temporalpassword' => 'Temporalpassword',
            'Tempralpasswordtime' => 'Tempralpasswordtime',
        ];
    }

    /**
     * Gets query for [[Username]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsername()
    {
        return $this->hasOne(Personaldata::class, ['Ci' => 'username']);
    }
    
    /**
     * Gets query for [[Personaldata]].
     *
     * @return \yii\db\ActiveQuery
     */

     public function getPersonaldata(){
        return $this->hasOne(Personaldata::class, ['Ci' => 'username']);
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'Status' => 1]); // Cambia esto según tus requisitos
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implementa la búsqueda por token aquí, si es necesario.
        return null;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'Status' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->Auth_key;
    }

    public function validatePassword($password)
    {
        return $this->password;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }



    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->Username);
        }

        return $this->_user;
    }


    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

}


