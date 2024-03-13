<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required', 'message' => '{attribute} no puede estar vacío.'],
            [['password'], 'required', 'message' => '{attribute} no puede estar vacía.'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Usuario',
            'password' => 'Contraseña',
            'rememberMe' => 'Recordar Sesión',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuario o contraseña incorrecta.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            // Intenta encontrar al usuario por su cédula
            $user = User::findByUsername($this->username);

            if ($user === null) {
                // Si no se encuentra al usuario en la tabla de usuarios, busca en otras tablas
                $student = Informacionpersonal::findByCedula($this->username);
                $teacher = InformacionpersonalD::findByCedula($this->username);

                if ($student !== null) {
                    // Si se encuentra en la tabla de Estudiantes, crea un nuevo usuario con los datos de Estudiantes
                    $user = new User();
                    $user->username = $student->CIInfPer; // Utiliza la cédula como nombre de usuario
                    $user->tipo_usuario = User::TYPE_ESTUDIANTE;
                    // Genera una contraseña segura y aleatoria
                    $user->setPassword($student->CIInfPer);
                    //$user->password = $student->ClaveUsu;
                    $user->Created_at = date('Y-m-d H:i:s');
                    $user->Auth_key = Yii::$app->security->generateRandomString();
                    // Guarda el usuario
                    $user->save();
                } elseif ($teacher !== null) {
                    // Si se encuentra en la tabla de Docentes, crea un nuevo usuario con los datos de Docentes
                    $user = new User();
                    $user->username = $teacher->CIInfPer; // Utiliza la cédula como nombre de usuario
                    $user->tipo_usuario = User::TYPE_DOCENTE;
                    // Genera una contraseña segura y aleatoria
                    $user->setPassword($teacher->CIInfPer);
                    //$user->password = $student->ClaveUsu;
                    $user->Created_at = date('Y-m-d H:i:s');
                    $user->Auth_key = Yii::$app->security->generateRandomString();
                    // Guarda el usuario
                    $user->save();
                }
            }

            $this->_user = $user;
        }

        return $this->_user;
    }

}
