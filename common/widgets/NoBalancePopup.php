<?php 

namespace common\widgets;

use Yii;
use yii\base\Widget;

class NoBalancePopup extends Widget 
{
	public function init()
	{
		parent::init();
	}


	public function run()
	{
		$content = '
			<div class="popup no-balance">
			    <div class="popup-content">
			        <span class="popup-close fa fa-close"></span>
			        <div class="popup-body">
			            <div class="row">
			                <div class="col-12">
			                    <h3 class="no-balance-header">У вас недостаточно средств</h3>
			                </div>
			                <div class="col-12">
			                    <p class="no-balance-text">Пополните баланс, чтобы получить доступ к заказу</p>
			                </div>
			                <div class="col-12">
			                	<a href="tel:+996(708)903-088" class="support">Техподдержка: +996(708)903-088</a>
			                </div>
			                <div class="col-12">
			                    <a href="tel:+996708903088" class="button green mb-10 full">Позвонить</a>
			                </div>
			                <div class="col-12">
			                    <a href="https://api.whatsapp.com/send?phone=+996708903088" class="button green full">WhatsApp</a>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>

		';

		return $content;
	}
}