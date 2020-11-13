<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\themes\vse\assets\LoginAsset;
use common\modules\content\models\Menu;

$menuList = Menu::getSidebarMenuList();

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php $this->registerCsrfMetaTags() ?>
<title>
    <?= Html::encode($this->title) ?>
</title>
<?php $this->head() ?>
</head>
<body class="login">
<?php $this->beginBody() ?>
    <div class="wrap">
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
							<li class="menu-item">
								<?= Html::a('Главная',Url::home(),['class' => 'menu-link']);?>
							</li>
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
        <section class="login-content"> 
			<div class="sidebar-wrap"></div>
			<div class="sidebar d-lg-none d-block">
				<ul class="sidebar-menu d-lg-none d-block">
					<li class="sidebar-menu-item">
						<span class="sidebar-menu-icon fas fa-home"></span>
						<a class="sidebar-menu-link" href="<?= Url::home();?>">Главная</a>
					</li>
				</ul>
			</div>
			<div class="container">
				<div class="row">
					 <div class="col-lg-5 d-lg-flex align-items-center d-none">
                        <p class="login-about">Сервис vsё поможет найти нужный товар и услугу, а так же специалиста</p>
                    </div>
					<div class="col-lg-7 d-flex align-items-center">
						<?= $content;?>
					</div>
				</div>
			</div>
		</section>
    </div>
    <div class="up-to-top" id="up-to-top"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>