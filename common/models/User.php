<?php
namespace common\models;

use Yii;
use common\models\Image;
use common\modules\message\models\Message;
use common\modules\order\models\Order;
use common\modules\order\models\PaidOrders;
use common\modules\profile\models\Stock;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 2;
    const STATUS_ACTIVE = 1;

    public $image;

    public $current;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
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
            [['email'],'safe'],
            [['username','surname','phone','photo'],'string','max' => 255],
            [['description'],'string'],
            [['balance'],'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['photo'],'default','value' => 'default.png'],
            [['image'],'safe'],
            [['balance'],'default','value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    //Связь
    public function getPaidOrders()
    {
        return $this->hasMany(PaidOrders::className(),['user_id' => 'id']);
    }

    //Cвязь
    public function getOrders()
    {
        return $this->hasMany(Order::className(),['author_id' => 'id']);
    }

    public function getSended()
    {
        return $this->hasMany(Message::className(),['author_id' => 'id']);
    }

    public function getMessage()
    {
        return $this->hasMany(Message::className(),['reciver_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if($insert)
        {
            $stock = Stock::find()->where(['title' => 'Бонус при регистрации'])->one();

            if(isset($stock) && !empty($stock))
            {   
                if($stock->status > 0)
                {
                    $this->balance += 45;
                }
            }
        }

        if(isset($this->image) && !empty($this->image))
        {   
            $this->current = $this->photo;

            $this->photo = $this->image->baseName.'.'.$this->image->extension;
        }
        
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {   
        $auth = Yii::$app->authManager;

        if($insert)
        {
             $user = $auth->getRole('user');

             $auth->assign($user,$this->id);
        }

        if(isset($this->image) && !empty($this->image))
        {
            $upload = new Image('profile');

            $upload->uploadImage($this->id,$this->image,$this->current);
        }

        $orders = $this->orders;

        if(isset($orders) && !empty($orders))
        {
            foreach($orders as $order)
            {
                $order->author_name = $this->getFullName();

                $order->save();
            }
        }

    }

    public function beforeDelete()
    {
        $auth = Yii::$app->authManager;

        $auth->revokeAll($this->id);

        $image = new Image('profile');

        $image->deleteDir($this->id);

        $this->unlinkAll('orders',true);

        $this->unlinkAll('paidOrders',true);

        $this->unlinkAll('sended',true);

        $this->unlinkAll('message',true);

        return parent::beforeDelete();
    }



    public function getImage()
    {   
        if($this->photo !== 'default.png')
        {
            return Yii::getAlias('@profile-img').'/users/'.$this->id.'/'.$this->photo;
        }
        else
        {
            return Yii::getAlias('@profile-img').'/'.Yii::$app->params['profileImg'];
        }
    }

    public function deleteImage()
    {
        $id = $this->id;

        $model = new Image('profile');

        $model->deleteDir($id);

        return true;
    }


    public function getUsername()
    {
        return (!empty($this->username)) ? $this->username : $this->email;
    }

    public function getSurname()
    {
        return (!empty($this->surname)) ? $this->surname : '';
    }

    public function getFullName()
    {
        return $this->getUsername().' '.$this->getSurname();
    }

    public function getPhone()
    {
        return (!empty($this->phone)) ? $this->phone : 'Не указан';
    }

    public function hasPhone()
    {
        if(isset($this->phone) && !empty($this->phone))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function setPhoneValue()
    {
        return (!empty($this->phone)) ? $this->phone : '';
    }

    public function checkBalance()
    {
        $balance = $this->balance;

        if($balance == 0)
        {
            return false;
        }

        if($balance < 15)
        {
            return false;
        }

        if($balance >= 15)
        {
            return true;
        }
    }

    public function takePayment($orderId)
    {   
        $order = Order::find()->where(['id' => $orderId])->one();

        if(!empty($order))
        {
            $model = new PaidOrders();

            $model->user_id = Yii::$app->user->getId();

            $model->order_id = $orderId;

            $model->status = 1;

            $this->balance -= 15;

            return $model->save();
        }
    }






}
