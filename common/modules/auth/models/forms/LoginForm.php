<?php
namespace common\modules\auth\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;
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
            [['login'], 'required','message' => 'Введите почту'],
            [['login'],'swearFilter'],
            [['password'], 'required','message' => 'Введите пароль'],
            // rememberMe must be a boolean value
            [['login'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['login' => 'email'],'message' => 'Пользователя с такой почтой не существует'],
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password','string','min' => 6,'tooShort' => 'Пароль должен содержать не менее 6 символов'],
        ];
    }

    public function swearFilter($attribute,$params)
	{
		$swearWords = Yii::$app->params['swearWords'];

		foreach($swearWords as $swear)
		{
			if(preg_match('/'.$swear.'/ui',$this->$attribute))
			{
				$this->addError($attribute,'Ошибка. Нецензурные выражения запрещены');
			}
		}
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
                $this->addError($attribute, 'Неверный пароль');
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

   
    protected function getUser()
    {   
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->login);
        }

        return $this->_user;
    }
	
}
