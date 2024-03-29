<?php 

namespace common\modules\message\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;
use common\modules\message\models\Message;

class WriteMessage extends Model 
{
	public $author_id;

	public $reciver_id;

	public $message;

	public function rules()
	{
		return [
			[['author_id','reciver_id'],'integer'],
			[['message'],'required','message' => 'Сообщение не может быть пустым'],
			[['message'],'string'],
			[['message'],'swearFilter'],
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


	public function sendMessage($author_id)
	{
		if($this->validate())
		{
			$model = new Message();

			$model->attributes = $this->attributes;

			$model->status = 1;

			$model->author_id = $author_id;

			return $model->save();
		}
	}
}
