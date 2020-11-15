<?php
namespace common\modules\auth\models\forms;

use Yii;

use common\models\User;

use common\modules\profile\models\Stock;

use yii\base\Model;

/**
 * Signup form
 */
class RegisterForm extends Model
{
    public $email;
    public $password;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required','message' => 'Введите email'],
            ['email', 'email','message' => 'Введите корректный email'],
            ['email', 'string', 'max' => 255,'message' => 'Слишком длинный email'],
            [['email','password'],'swearFilter'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'Пользователь с таким email уже существует'],
            ['password', 'required','message' => 'Введите пароль'],
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
				$this->addError($attribute,'Нецензурные выражения запрещены');
			}
            elseif(preg_match('/^ам$/ui',$this->$attribute))
            {
                $this->addError($attribute,'Нецензурные выражения запрещены');
            }
		}
	}

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function register($request)
    {
        if($this->load($request->post()) && $this->validate())
        {
            $user = new User();

            $user->email = $this->email;

            $user->setPassword($this->password);

            $user->generateAuthKey();

            $user->generateEmailVerificationToken();

            if($user->save())
            {   
                Yii::$app->session->setFlash('success','Вы успешно зарегестрированы');

                return Yii::$app->user->login($user);
            }
        }
    }

}
