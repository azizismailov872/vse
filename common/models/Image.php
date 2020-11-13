<?php 

namespace common\models;

use Yii;
use yii\base\Model;


class Image extends Model 
{	
	public $path;

	public $type;

	function __construct($modelType)
	{
		$this->type = $modelType;

		if($this->type == 'profile')
		{
			$this->path = Yii::getAlias('@common').'/modules/profile/images';
		}
		elseif($this->type == 'category')
		{
			$this->path = Yii::getAlias('@common').'/modules/order/images';
		}

	}

	public function rules()
	{
		return [
			[['image'],'file','extensions' => 'jpg, png'],
		];
	}

	/*
	* Загрузка фото
	* @id - Id Пользователя или категории которой принадлежит фото
	* @image - Фотография
	* @existImage - Существующая фотография
	*/
	public function uploadImage($id,$image,$existImage)
	{	
		$uploadPath = $this->getDir($id);

		$this->checkCurrent($id,$existImage);
		
		$imageName = $image->baseName.'.'.$image->extension;

		if($image->saveAs($uploadPath.'/'.$imageName))
		{
			return true;
		}
	}

	/*
	* Возвращает директорию категории или пользователяв которой хранятся фото
	* @id - Id Пользователя или категории которой принадлежит фото
	*/
	public function getDir($id)
	{
		$directory =  $this->path.'/users/'.$id;

		if($this->type == 'category')
		{
			$directory = $this->path.'/'.$id;
		}
		
		if(!is_dir($directory) && !file_exists($directory))
        {
            mkdir($directory,0755,true);

            return $directory;
        }
        else
        {
            return $directory;
        }
	}

	/*
	* Удаляет директорию категории или пользователяв которой хранятся фото
	* @id - Id Пользователя или категории которой принадлежит фото
	*/
	public function deleteDir($id)
    {   
        $dir = $this->getDir($id);
        
        if(is_dir($dir) && file_exists($dir))
        {
            system("rm -rf ".escapeshellarg($dir));
            return true;
        }
        else
        {
            return false;
        }
    }

    public function checkCurrent($id,$current)
    {	

    	$file = $this->getDir($id).'/'.$current;

    	if(file_exists($file))
    	{
    		system("rm -rf ".escapeshellarg($file));

    	}
    }

}