<?php 

namespace common\widgets;

use Yii;
use common\modules\order\models\PaidOrders;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;


class OrderButton extends Widget 
{

	public $user;

	public $order;

	public $paid;

	public function init()
	{
		parent::init();

		if(!Yii::$app->user->isGuest)
		{
			$this->user = Yii::$app->user->identity;

			$this->paid = PaidOrders::find()->where(['user_id' => $this->user->id,'order_id' => $this->order->id])->one();
		}
	}

	public function run()
	{

		if(Yii::$app->user->can('updateOrder',['item' => $this->order]) or Yii::$app->user->can('admin'))
		{
			$content = '
				<div class="col-lg-4">'.
					Html::a('Редактировать',Url::toRoute(['/order/update/'.$this->order->id]),[
						'class' => 'button full green mb-sm-10'
					])
				.'
				</div>
				<div class="col-lg-4">'.
					Html::a('Удалить',Url::toRoute(['/order/delete/'.$this->order->id]),[
						'class' => 'button red full',
					])
				.'
			';
		}
		elseif(isset($this->paid) && !empty($this->paid))
		{
			if($this->order->status == 0)
			{
				$content = '
						<div class="col-lg-4">'.
							Html::button('Контакты',[
								'class' => 'button full green',
								'id' => 'no-active',
							])
						.'
					';
			}
			else
			{
				$content = '
					<div class="col-lg-4">'.
						Html::button('Контакты',[
							'class' => 'button full green popup-open',
							'id' => 'call',
						])
					.'
				';
			}
			
		}
		elseif(!Yii::$app->user->isGuest)
		{	
			$balance = $this->user->checkBalance();
			
			if($balance)
			{	
				if($this->order->status == 0)
				{
					$content = '
						<div class="col-lg-4">'.
							Html::button('Контакты',[
								'class' => 'button full green',
								'id' => 'no-active',
							])
						.'
					';
				}
				else
				{
					$content = '
						<div class="col-lg-4">'.
							Html::button('Контакты',[
								'class' => 'button full green  popup-open',
								'id' => 'call',
								'onclick' => 'takePayment(this)'
							])
						.'
					';
				}
			}
			else
			{
				$content = '
					<div class="col-lg-4">'.
						Html::button('Контакты',[
							'class' => 'button full green popup-open',
							'id' => 'no-balance',
						])
					.'
				';
			}
		}
		elseif(Yii::$app->user->isGuest)
		{
			$content = '
				<div class="col-lg-4">'.
					Html::button('Контакты',[
						'class' => 'button full green popup-open',
						'id' => 'register',
					])
				.'
			';
		}


		return $content;
	}

}