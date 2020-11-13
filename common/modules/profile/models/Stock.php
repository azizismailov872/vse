<?php

namespace common\modules\profile\models;

use Yii;
use common\models\User;


/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $description
 * @property string|null $phone
 * @property string|null $photo
 * @property float|null $balance
 * @property int|null $completed
 *
 * @property User $user
 */
class Stock extends \yii\db\ActiveRecord
{   

    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'],'required','message' => 'Это поле обязательно'],
            [['title'],'string','max' => 255,'message' => 'Слишком длинное значение'],
            [['status'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title' => 'Название',
            'status' => 'Статус',
        ];
    }

    
    

}
