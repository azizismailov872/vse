<?php 

namespace common\widgets;

use Yii;
use common\modules\message\Message;
use common\models\User;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;

class MessageButton extends Widget 
{

	public $message;

	public function init()
	{
		parent::init();
	}


	public function run()
	{
		if(Yii::$app->user->can('manageMessage',['item' => $this->message]))
		{
			$content = ' 
		        <div class="col-lg-4">
		        	'.
		        		Html::a('Написать еще','',[
		        			'class' => 'button full green mb-sm-10 popup-open',
		        			'id' => 'write-message-more',
		        		])
		        	.'
		        </div>
		        <div class="col-lg-4">
		            '.
		            	Html::a('Удалить',Url::toRoute(['/profile/message/delete/'.$this->message->id]),[
		            		'class' => 'button red full',
		            	])
		            .'
		        </div>
			';
		}
		elseif(!Yii::$app->user->isGuest)
		{
			if(Yii::$app->user->getId() == $this->message->reciver_id)
			{
				 $content = '
				 	<div class="col-lg-4">
				 		'.
				 			Html::a('Ответить','',[
			        			'class' => 'button full green mb-sm-10 popup-open',
			        			'id' => 'write-message-answer',
		        			])
				 		.'
				 	</div>
				 	<div class="col-lg-4">
			            '.
			            	Html::a('Удалить',Url::toRoute(['/profile/message/delete/'.$this->message->id]),[
			            		'class' => 'button red full',
			            	])
			            .'
			        </div>
				 ';
			}
		}

		return $content;
	}
}