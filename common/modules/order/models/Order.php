<?php

namespace common\modules\order\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use DateTime;
/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $author_id
 * @property int|null $category_id
 * @property string $content
 * @property string $author_name
 * @property string $author_phone
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $author
 * @property Category $category
 * @property PaidOrders[] $paidOrders
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required','message' => 'Опишите заказ'],
            [['category_id'],'required','message' => 'Выберите категорию'],
            [['author_phone'],'required','message' => 'Введите номер'],
            [['author_id', 'category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['author_name', 'author_phone'], 'string', 'max' => 255,'message' => 'Слишком длинное имя'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['author_name'],'default','value' => 'Гость'],
            [['status'],'default','value' => 1],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'category_id' => 'Категория',
            'content' => 'Заказ',
            'author_name' => 'Имя автора',
            'author_phone' => 'Телефон автора',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function beforeSave($insert)
    {
        if($insert)
        {
            if(!Yii::$app->user->isGuest)
            {   
                $user = Yii::$app->user->identity;

                $this->author_id = $user->id;

                $this->author_name = (!empty($user->username)) ? $user->username : $user->email;
            }

            if(!isset($this->author_id) && empty($this->author_id))
            {
                $user = User::find()->where(['username' => 'Без автора'])->one();

                $this->author_id = $user->id;

                $this->author_name = 'Гость';
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[PaidOrders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaidOrders()
    {
        return $this->hasMany(PaidOrders::className(), ['order_id' => 'id']);
    }

    public static function getUsersList()
    {
        return ArrayHelper::map(User::find()->asArray()->all(),'id','email');
    }

    public function substrContent()
    {
        return trim($this->content).'...';
    }

    public function canWriteMessage()
    {
        $author = User::find()->where(['id' => $this->author_id])->one();

        if(isset($author) && !empty($author))
        {
            if($author->username == 'Без автора')
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }

    public function new_time($a) 
    { 
         date_default_timezone_set('Asia/Bishkek');
         $ndate = date('Y-m-d', $a);
         $ndate_time = date('H:i', $a);
         $ndate_exp = explode('-', $ndate);
        
         $nmonth = array(
          1 => 'янв',
          2 => 'фев',
          3 => 'мар',
          4 => 'апр',
          5 => 'мая',
          6 => 'июн',
          7 => 'июл',
          8 => 'авг',
          9 => 'сен',
          10 => 'окт',
          11 => 'ноя',
          12 => 'дек'
         );

         foreach ($nmonth as $key => $value) {
          if($key == intval($ndate_exp[1])) $nmonth_name = $value;
         }

         if($ndate == date('Y-m-d')) return 'Cегодня в '.$ndate_time;
         elseif($ndate == date('Y-m-d', strtotime('-1 day'))) return 'Вчера в '.$ndate_time;
         else return $ndate_exp[2].' '.$nmonth_name.' '.$ndate_time;
        /* else return $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2].' в '.$ndate_time;*/
        
    }

    public function setNoActive()
    {   
        $toDay = new DateTime(date('Y-m-d'));

        $createdAt = new DateTime(date('Y-m-d',$this->created_at));

        $diff  = $toDay->diff($createdAt);

        if($diff->d > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

   


}
