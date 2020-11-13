<?php

namespace common\modules\order\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\modules\order\models\Order;
use common\models\Image;
/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string|null $background
 * @property string|null $url
 * @property int|null $order
 * @property int|null $status
 * @property int|null $parent_id
 * @property string|null $icon
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Order[] $orders
 */
class Category extends \yii\db\ActiveRecord
{   

    public $image;

    public $current;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required','message' => 'Поле "название" не может быть пустым'],
            [['order', 'status', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'background', 'url', 'icon'], 'string', 'max' => 255],
            [['parent_id'],'default','value' => 0],
            [['status'],'default','value' => 1],
            [['background'],'default','value' => 'main-bg.jpg'],
            [['image'],'file','extensions' => 'jpg, png'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'background' => 'Фон',
            'url' => 'Ссылка',
            'order' => 'Очередь',
            'status' => '',
            'parent_id' => 'Родитель',
            'icon' => 'Icon',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['category_id' => 'id']);
    }

    public static function getCategoriesList()
    {
        return ArrayHelper::map(self::find()->orderBy('order')->asArray()->all(),'id','title');
    }

    public static function getCategoryList()
    {
        $categoryList = self::find()->where(['status' => 1])->orderBy('order')->asArray()->all();

        foreach($categoryList as $item)
        {
            $result[] = [
                'title' => $item['title'],
                'url' => $item['url'],
                'icon' => $item['icon'],
            ];
        }

        return $result;
    }


    public function beforeSave($insert)
    {
        if(isset($this->image) && !empty($this->image))
        {   
            $this->current = $this->background;

            $this->background = $this->image->baseName.'.'.$this->image->extension;
        }
        
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {   
        if(isset($this->image) && !empty($this->image))
        {
            $upload = new Image('category');

            $upload->uploadImage($this->id,$this->image,$this->current);
        }

    }

    public function beforeDelete()
    {
        $image = new Image('category');

        $image->deleteDir($this->id);

        return parent::beforeDelete();
    }

    public function getImage()
    {   
        if($this->background !== 'main-bg.jpg')
        {
            return Yii::getAlias('@categories-bg').'/'.$this->id.'/'.$this->background;
        }
        else
        {
            return Yii::$app->params['defaultCategoryBg'];
        }
    }

    public function deleteImage()
    {
        $id = $this->id;

        $model = new Image('category');

        $model->deleteDir($id);

        return true;
    }



    
    
}
