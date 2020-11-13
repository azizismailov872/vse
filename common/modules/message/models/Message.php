<?php

namespace common\modules\message\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $author_id
 * @property int $reciver_id
 * @property string|null $message
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $author
 * @property User $reciver
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'reciver_id'], 'required'],
            [['author_id', 'reciver_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['reciver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reciver_id' => 'id']],
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
            'author_id' => 'Author ID',
            'reciver_id' => 'Reciver ID',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * Gets query for [[Reciver]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReciver()
    {
        return $this->hasOne(User::className(), ['id' => 'reciver_id']);
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

    public function substrContent()
    {
        if(strlen($this->message) > 80)
        {
            return nl2br(mb_substr($this->message,0,80).'...');
        }
        else
        {
            return nl2br($this->message);
        }
    }

    public function canWriteMessage()
    {
        $author = User::find()->where(['id' => $this->author_id])->one();

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
