<?php

use yii\helpers\Html;
use frontend\themes\vse\assets\AppAsset;
use common\modules\order\models\Category;
use common\modules\content\models\Menu;
use yii\widgets\Pjax;
use yii\helpers\Url;

$menuList = Menu::getSidebarMenuList();

$categoriesList = Category::getCategoryList();

AppAsset::register($this);
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
<body>
<?php $this->beginBody() ?>
    <div class="wrap">
        <?= $this->render('header');?>
        <section class="category" style="background-image: url(<?= Yii::$app->params['defaultCategoryBg'];?>);">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2><a href="<?= Url::toRoute([Yii::$app->params['categoryUrl']]);?>" class="category-title"><?= Yii::$app->params['categoryTitle'];?></a></h2>
                    <?php if(Yii::$app->params['categorySubTitle'] !== null):?>
                        <h3 class="category-sub-title text-center"><?= Yii::$app->params['categorySubTitle'];?></h3>
                    <?php endif;?>
                </div>
            </div>
        </section>
        <section class="main">
            <div class="sidebar-wrap"></div>
            <div class="container">
            <?php Pjax::begin(['id' => 'alerts']);?>
                <?php if( Yii::$app->session->hasFlash('success') ): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo Yii::$app->session->getFlash('success'); ?>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <?php if( Yii::$app->session->hasFlash('error') ):?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible" role="alert" id="error-alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo Yii::$app->session->getFlash('error'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php Pjax::end();?>
                <div class="row">
                    <div class="col-lg-4">
                        <?= $this->render('sidebar',[
                            'menuList' => $menuList,
                            'categoriesList' => $categoriesList,
                        ]);?>
                    </div>
                    <div class="col-lg-8">
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