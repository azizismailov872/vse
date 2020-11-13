<?php
use backend\themes\gentella\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\content\models\Menu;
use yii\widgets\Menu as MenuWidget; 

AppAsset::register($this);

$menuList = Menu::getAdminMenuList();
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
<body class="nav-md">
    <?php $this->beginBody() ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Панель администратора</span></a>
            </div>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?= Yii::$app->user->identity->getImage();?>" alt="" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Добро пожаловать</span>
                <h2><?= (!empty(Yii::$app->user->identity->username)) ? Yii::$app->user->identity->username : 'Пользователь' ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Панель управления</h3>
                <?= MenuWidget::widget([
                      'items' => $menuList,
                      'hideEmptyItems' => true,
                      'options' => ['class' => 'nav side-menu'],
                      'submenuTemplate' => "\n<ul class='nav child_menu'>\n{items}\n</ul>\n",
                    ]);
                 ?>
              </div>
            </div>
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?= Yii::$app->user->identity->getImage();?>">
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="<?= Url::toRoute(['/user/view/'.Yii::$app->user->getId()])?>">Профиль</a>
                    <a class="dropdown-item"  href="<?= Url::toRoute(['/logout']);?>"><i class="fa fa-sign-out pull-right"></i>Выйти</a>
                  </div>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="clearfix"></div>
          <?= $content;?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <a href="htts://instagram.com/nemovstud">Разработчик Aziz Ismailov</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>