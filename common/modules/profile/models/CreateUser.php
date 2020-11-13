<?php 

namespace common\modules\profile\models;

use yii\base\Model;
use common\models\User;
use common\models\Image;

class CreateUser extends Model
{
	const STATUS_ACTIVE = 1;

	const STATUS_DELETED = 0;

	public $email;

	public $username;

	public $surname;

	public $password;

	public $description;

	public $phone;

	public $status;

	public $balance;

	public $image;

	public function rules()
	{
		return [
			[['email'],'email'],
			[['email'],'required','message' => 'Email Не может быть пустым'],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким email уже существует !'],
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким именем уже существует !'],
			['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким номером уже существует !'],
			[['password'],'required','message' => 'Пароль не должен быть пустым'],
			[['email','username','surname','phone','password'],'string','max' => 255,'message' => 'Превышена максимальная длинна'],
			[['description'],'string'],
			[['status','balance'],'integer'],
			[['balance'],'default','value' => 0],
			[['status'],'default','value' => 1],
			[['image'],'file','extensions' => 'jpg, png, jpeg'],
		];
	}

	public function attributeLabels()
	{
		return [
			'status' => '',
		];
	}

	public function createUser($image = null)
	{
		$model = new User();
		
		if($this->validate())
		{	
			$model->attributes = $this->attributes;

			$model->image = (!empty($image)) ? $image : null;
	
			$model->setPassword($this->password);

			$model->generateAuthKey();

        	$model->generateEmailVerificationToken();
        	
        	return $model->save();

		}
	}

	
}