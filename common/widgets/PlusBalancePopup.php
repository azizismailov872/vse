<?php 

namespace common\widgets;

use Yii;
use yii\base\Widget;

class PlusBalancePopup extends Widget 
{
	public function init()
	{
		parent::init();
	}


	public function run()
	{
		$content = '
			<div class="popup plus-balance">
				<div class="popup-content">
					<span class="popup-close fa fa-close"></span>
					<div class="popup-body">
						<div class="row">
							<div class="col-12">
								<h3 class="plus-balance-header">Пополните баланс</h3>
							</div>
							<div class="col-12">
								<p class="plus-balance-text">Свяжитесь с администратором для пополнения баланса</p>
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