<?php 

namespace common\modules\order\models\forms;

use Yii;
use yii\base\Model;
use common\modules\order\models\Category;

class UpdateCategory extends Model 
{
	public $category;

	public $title;

	public $url;

	public $status;

	public $image;

	public $order;

	public $icon;

	public function rules()
	{
		return [
			[['title'],'checkUniqueTitle'],
			[['url'],'checkUniqueUrl'],
			[['title','url','icon'],'string'],
			[['order','status'],'integer'],
			[['image'],'file','extensions' => 'jpg, png'],
		];
	}

	function __construct($categoryModel)
	{	
		$this->category = $categoryModel;

		$this->attributes = $categoryModel->attributes;
	}

	public function attributeLabels()
	{
		return [
			'status' => '',
		];
	}

	public function checkUniqueTitle($attribute,$params)
	{
		$value = $this->$attribute;

		$category = Category::find()->where([$attribute => $value])->one();

		if(isset($category) && !empty($category))
		{
			if($category->id !== $this->category->id)
			{
				if($category->title == $this->category->title)
				{
					$this->addError($attribute, 'Категория с таким названием уже существует');
				}
			}
		}
	}

	public function checkUniqueUrl($attribute,$params)
	{
		$value = $this->$attribute;

		$category = Category::find()->where([$attribute => $value])->one();

		if(isset($category) && !empty($category))
		{
			if($category->id !== $this->category->id)
			{
				if($category->url == $this->category->url)
				{
					$this->addError($attribute, 'Категория с такой ссылкой уже существует');
				}
			}
		}
	}


	public function saveCategory($image = null)
	{
		if($this->validate())
		{
			$this->category->attributes = $this->attributes;

			$this->category->image = (!empty($image)) ? $image : null;

			return $this->category->save();
		}
	}
}