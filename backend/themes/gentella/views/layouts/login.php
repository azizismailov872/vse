<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\themes\gentella\assets\AdminLoginAsset;
use common\modules\content\models\Menu;

$menuList = Menu::getSidebarMenuList();

AdminLoginAsset::register($this);
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
                            <?php if(Yii::$app->user->isGuest):?>
                            <li class="menu-item">
                                <?= Html::a('Вход',Url::toRoute(['/login']),['class' => 'menu-link']);?>
                            </li>
                            <?php elseif(!Yii::$app->user->isGuest):?>
                                <li class="menu-item">
                                <?= Html::a('Выход ('.Yii::$app->user->identity->getUsername().')',Url::toRoute(['/logout']),['class' => 'menu-link']);?>
                            </li>
                            <?php endif;?>
                        </ul>
                    </div>
                    <div class="col-2 d-lg-none d-block">
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
                    <?php if(Yii::$app->user->isGuest):?>
                    <li class="sidebar-menu-item">
                        <span class="sidebar-menu-icon fas fa-home"></span>
                        <a class="sidebar-menu-link" href="<?= Url::home();?>">Главная</a>
                    </li>
                    <li class="sidebar-menu-item">
                        <span class="sidebar-menu-icon fas fa-sign-in-alt"></span>
                        <a class="sidebar-menu-link" href="<?= Url::toRoute(['/login']);?>">Вход</a>
                    </li>
                    <li class="sidebar-menu-item">
                        <span class="sidebar-menu-icon fas fa-sign-in-alt"></span>
                        <a class="sidebar-menu-link" href="<?= Url::toRoute(['/register']);?>">Регистрация</a>
                    </li>
                    <?php endif;?>
                    <?php if(!Yii::$app->user->isGuest):?>
                    <li class="sidebar-menu-item d-lg-none d-block">
                        <span class="sidebar-menu-icon fas fa-sign-out-alt"></span>
                        <a class="sidebar-menu-link" href="<?= Url::toRoute(['/logout']);?>">Выход</a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 offset-lg-1 d-flex align-items-center">
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