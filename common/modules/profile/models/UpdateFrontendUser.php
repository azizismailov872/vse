<?php 

namespace common\modules\profile\models;

use Yii;
use common\models\User;
use yii\base\Model;


class UpdateFrontendUser extends Model
{	
	public $user;

	public $email;

	public $username;

	public $surname;

	public $phone;

	public $description;

	public $balance;

	public $oldPassword;

	public $newPassword;

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
			[['newPassword'],'string','max' => 255,'tooLong' => 'Новый пароль слишком длинный'],
			[['email'],'email','message' => 'Введите корректный  email'],
			[['email'],'checkUniqueEmail'],
			[['email'],'required','message' => 'Введите email'],
			[['username'],'checkUniqueUsername'],
			[['status','balance'],'integer'],
			[['username','surname','newPassword'],'string','max' => 255],
			[['image'],'file','extensions' => 'jpg, png, jpeg'],
			[['photo'],'string'],
			[['oldPassword'],'validatePassword'],
			[['phone'],'minPhone'],
			[['phone'],'checkUniquePhone'],
			[['description'],'phoneFilter'],
			[['description'],'string','min' => 6,'tooShort' => 'Слишком короткое описание'],
			[['username','surname','description','email'],'swearFilter'],
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

	public function phoneFilter($attribute,$params)
	{	
		$numberLayout = [
			'/\+996[0-9]{4,}/ui',
			'/0[0-9]{3}[0-9]{4,}/ui',
			'/[0-9]{9,}/ui',
		];

		foreach($numberLayout as $number)
		{
			if(preg_match($number,$this->$attribute))
			{
				$this->addError($attribute,'Указывать номер телефона в описании запрещено');
			}
		}
	}

	public function validatePassword($attribute,$params)
	{
		/*$user = User::find()->where(['id' => $this->user_id])->one();*/

		if (!$this->hasErrors()) {
            if (!$this->user || !$this->user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Неправильный старый пароль');
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

	public function minPhone($attribute,$params)
	{
		$reg = '/\+996\([0-9]{3}\)[0-9]{3}\-[0-9]{3}/';

		if(!preg_match($reg, $this->$attribute))
		{
			$this->addError($attribute,'Введите полный номер');
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

			if(isset($this->newPassword) && !empty($this->newPassword))
			{
				$this->user->setPassword($this->newPassword);
			}
			
			return $this->user->save();

		
		}
	}
}