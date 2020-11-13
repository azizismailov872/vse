<?php 

namespace common\widgets;

use Yii;
use common\modules\order\models\Order;
use yii\helpers\Url;
use yii\base\Widget;

class OrderList extends Widget
{
	public $orders;

    public $profile;

	public function init()
	{
		parent::init();
	}


	public function run()
	{
		foreach($this->orders as $order)
		{
			if($this->profile)
            {
                echo '<div class="order" id="'.$order->id.'" onclick="openOrder(this)">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-auto">
                            <a href="'.Url::toRoute(['/order/view/'.$order->id]).'"class="order-header">'.$order->category->title.'</a>
                        </div>
                        <div class="col-lg-4 d-lg-flex justify-content-end ">
                            <span class="order-time">'.$order->new_time($order->created_at).'</span>
                        </div>
                    </div>
                    <div class="row content-row">
                        <div class="col-12">
                            <p class="order-content">
                            '.$order->substrContent().'
                        </p>
                        </div>
                    </div>
                </div>';
            }
            else
            {
                echo '<div class="order" id="'.$order->id.'" onclick="openOrder(this)">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-auto">
                            <a href="'.Url::toRoute(['/category/'.$order->category->url]).'"class="order-header">'.$order->category->title.'</a>
                        </div>
                        <div class="col-lg-4 d-lg-flex justify-content-end ">
                            <span class="order-time">'.$order->new_time($order->created_at).'</span>
                        </div>
                    </div>
                    <div class="row content-row">
                        <div class="col-12">
                            <p class="order-content">
                            '.$order->substrContent().'
                        </p>
                        </div>
                    </div>
                </div>';
            }
		}
	}
}