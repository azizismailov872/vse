<?php 

namespace common\modules\order\models\forms;

use common\modules\order\models\Category;
use common\models\Image;
use yii\base\Model;

class CreateCategory extends Model
{
	const STATUS_ACTIVE = 1;

	const STATUS_DELETED = 0;

	public $title;

	public $url;

	public $status;

	public $image;

	public $order;

	public $icon;

	public function rules()
	{
		return [
			[['title'],'unique','targetClass' => Category::className(),'targetAttribute' => ['title' => 'title'],'message' => 'Категория с таким названием уже существует'],
			[['url'],'unique','targetClass' => Category::className(),'targetAttribute' => ['url' => 'url'],'message' => 'Категория с такой ссылкой уже существует'],
			[['title','url','icon'],'string','message' => 'Превышено максимальное колличество символов'],
			[['status','order'],'integer'],
			[['status'],'default','value' => self::STATUS_ACTIVE],
			[['order'],'default','value' => 0],
			[['image'],'file','extensions' => 'jpg, png'],
		];
	}

	public function attributeLabels()
	{
		return [
			'status' => '',
		];
	}

	public function createCategory($image = null)
	{
		$model = new Category();

		if($this->validate())
		{
			$model->attributes = $this->attributes;

			$model->image = (!empty($image)) ? $image : null;

			return $model->save();
		}
	}

	
}