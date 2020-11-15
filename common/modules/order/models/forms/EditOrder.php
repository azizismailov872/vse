<?php 

namespace common\modules\order\models\forms;

use Yii;
use yii\base\Model;
use common\modules\order\models\Order;
use common\models\User;

class EditOrder extends Model
{
	public $author_id;

	public $category_id;

	public $author_name;

	public $author_phone;

	public $content;

	public $status;

	public $order;

	public function rules()
	{
		return [
			[['author_phone'],'required','message' => 'Введите номер'],
			[['author_name'],'required','message' => 'Введите имя'],
			[['content'],'required','message' => 'Опишите ваш заказ'],
			[['category_id'],'required','message' => 'Выберите категорию'],
			[['author_id','category_id','status'],'integer'],
			[['author_name','author_phone'],'string','max' => 255,'message' => 'Превышено максимальное колличество символов'],
			[['content'],'string'],
			[['content'],'swearFilter'],
			[['author_phone'],'minPhone'],
		];
	}

	function __construct($order)
	{
		$this->attributes = $order->attributes;

		$this->order = $order;
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

	public function minPhone($attribute,$params)
	{
		$reg = '/\+996\([0-9]{3}\)[0-9]{3}\-[0-9]{3}/';

		if(!preg_match($reg, $this->$attribute))
		{
			$this->addError($attribute,'Введите полный номер');
		}
	}

	public function attributeLabels()
	{	
		return [
			'author_id' => 'Автор',
			'category_id' => 'Категория',
			'author_name' => 'Имя автора',
			'author_phone' => 'Телефон',
			'content' => 'Описание',
			'status' => 'Статус',
		];
	}


	public function saveOrder()
	{
		if($this->validate())
		{
			$this->order->attributes = $this->attributes;

			$this->order->status = 1;

			$this->order->content = trim($this->content,'\n');

			return $this->order->save();
		}
	}

}