<?php 

namespace common\modules\profile\models;

use Yii;
use yii\base\Model;
use common\models\User;

class PlusBalance extends Model
{
	public $email;

	public $balance;

	public function rules()
	{
		return [
			[['email'],'required','message' => 'Поле email не может быть пустым !'],
			[['balance'],'required','message' => 'Укажите сумму пополнения баланса'],
			[['email'],'string','max' => 255],
			[['balance'],'integer'],
			[['email'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email'],'message' => 'Пользователя с такой почтой не существует !'],

		];
	}

	public function plusBalance()
	{
		if($this->validate())
		{
			$model = User::find()->where(['email' => $this->email])->one();

			if(!empty($model))
			{
				$model->balance += $this->balance;

				return $model->save();
			}
		}
	}
}