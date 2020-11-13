<?php 

namespace common\modules\profile\models;

use Yii;
use common\models\User;
use yii\base\Model;


class UpdateUser extends Model
{	
	public $user;

	public $email;

	public $username;

	public $surname;

	public $phone;

	public $description;

	public $balance;

	public $password;

	public $status;

	public $image;

	public $photo;

	function __construct($user)
	{
		$this->user = $user;

		$this->attributes = $user->attributes;
	}

	public function rules()
	{
		return [
			[['password'],'string','max' => 255,'message' => 'Cлишком длинный пароль'],
			[['email'],'email'],
			[['email'],'checkUniqueEmail'],
			[['username'],'checkUniqueUsername'],
			[['status','balance'],'integer'],
			[['username','surname','password','phone'],'string','max' => 255],
			[['image'],'file','extensions' => 'jpg, png, jpeg'],
			[['photo'],'string'],
			[['phone'],'checkUniquePhone'],
			[['description'],'string'],
		];
	}

	public function attributeLabels()
	{
		return [
			'status' => '',
		];
	}

	public function checkUniqueEmail($attribute,$params)
	{
		$value = $this->$attribute;

		$user = User::find()->where([$attribute => $value])->one();

		if(isset($user) && !empty($user))
		{
			if($user->id !== $this->user->id)
			{
				if($user->email == $this->email)
				{
					$this->addError($attribute, 'Этот email занят другим пользователем');
				}
			}
		}

	}

	public function checkUniquePhone($attribute,$params)
	{
		$user = User::find()->where(['phone' => $this->$attribute])->one();

		if(isset($user) && !empty($user))
		{
			if($user->id !== $this->user->id)
			{
				$this->addError($attribute,'Этот номер телефона уже используется');
			}
		}
	}

	public function checkUniqueUsername($attribute,$params)
	{
		$value = $this->$attribute;

		$user = User::find()->where([$attribute => $value])->one();

		if(isset($user) && !empty($user))
		{
			if($user->id !== $this->user->id)
			{
				if($user->username == $this->username)
				{
					$this->addError($attribute,'Пользователь с таким именем уже существует');
				}
			}
		}
	}

	public function saveUser($image = null)
	{
		if($this->validate())
		{	
			$this->user->attributes = $this->attributes;

			$this->user->image = (!empty($image)) ? $image : null;

			if(isset($this->password) && !empty($this->password))
			{
				$this->user->setPassword($this->password);
			}
		
			return $this->user->save();
		}
	}
}