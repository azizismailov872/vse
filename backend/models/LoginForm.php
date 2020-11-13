<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\ArrayHelper;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login'], 'required','message' => 'Поле "Логин" не может быть пустым !'],
            [['password'], 'required','message' => 'Поле "Пароль" не может быть пустым !'],
            // rememberMe must be a boolean value
            [['login'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['login' => 'email'],'message' => 'Пользователя с такой почтой не существует !'],
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '',
            'login' => '',
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
        if (!$this->hasErrors()) 
        {
            $user = $this->getUser();

            $role = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($user->id),'name');

            foreach($role as $item)
            {   

                if($item == 'admin' or $item == 'editor')
                {
                    if (!$user || !$user->validatePassword($this->password)) {
                        $this->addError($attribute, 'Неправильный логин или пароль !');
                    }
                }
                else
                {
                    $this->addError($attribute,'Пользователь не является администратором или редактором');
                }
            }   
            
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    public function loginAdmin($request)
    {
        if($this->load($request->post()) && $this->validate())
        {
            if($this->login())
            {
                return true;
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->login);
        }

        return $this->_user;
    }
	

}
