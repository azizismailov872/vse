<?php 

use yii\helpers\Url;
use yii\helpers\Html;

?>
<header class="header">
	<div class="container">
		<div class="row justify-content-between align-items-center">
			<div class="col-2 col-lg-2">
				<div class="logo">
					<?= Html::a('vsё',Url::home(),['class' => 'logo-text']);?>
				</div>
			</div>
			<div class="col-lg-10 d-lg-block d-none">
				<ul class="menu">
					<?php if(Yii::$app->user->isGuest):?>
					<li class="menu-item">
						<?= Html::a('Вход',Url::toRoute(['/login']),['class' => 'menu-link']);?>
					</li>
					<?php elseif(!Yii::$app->user->isGuest):?>
						<li class="menu-item">
						<?= Html::a('Выход ('.Yii::$app->user->identity->getFullName().')',Url::toRoute(['/logout']),['class' => 'menu-link']);?>
					</li>
					<?php endif;?>
				</ul>
			</div>
			<div class="col-2 d-lg-none">
				<div class="burger-btn" onclick="activeBurgerMenu(this)">
					<div class="burger"></div>
				</div>
			</div>
		</div>
	</div>
</header>