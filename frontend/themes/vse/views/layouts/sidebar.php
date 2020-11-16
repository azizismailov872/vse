<?php 

use yii\helpers\Url;
?>
<div class="sidebar">
    <?php if(!Yii::$app->user->isGuest):?>
    <ul class="sidebar-menu">
        <?php foreach($menuList as $menu):?>
        <li class="sidebar-menu-item">
            <span class="sidebar-menu-icon <?= $menu['icon'];?>"></span>
            <a class="sidebar-menu-link" href="<?= Url::toRoute(['/'.$menu['url']]);?>"><?= $menu['title'];?></a>
        </li>
        <?php endforeach;?>
        <li class="sidebar-menu-item d-lg-none d-flex">
            <span class="sidebar-menu-icon fas fa-sign-out-alt"></span>
            <a class="sidebar-menu-link" href="<?= Url::toRoute(['/logout']);?>">Выход</a>
        </li>
    </ul>
    <?php endif;?>
    <?php if(Yii::$app->user->isGuest):?>
    <ul class="sidebar-menu d-lg-none d-block">
        <li class="sidebar-menu-item">
            <span class="sidebar-menu-icon fas fa-sign-in-alt"></span>
            <a class="sidebar-menu-link" href="<?= Url::toRoute(['/login'])?>">Вход</a>
        </li>
    </ul>
    <?php endif;?>
    <div class="categories">
        <h2 class="categories-heading">
            Категории 
        </h2>
        <ul class="categories-list">
            <li class="categories-item">
                <a href="<?= Url::home();?>" class="categories-link">Все</a>
            </li>
            <?php foreach($categoriesList as $category):?>
            <li class="categories-item">
                <span class="categories-icon <?= $category['icon'];?>"></span>
                <a href="<?= Url::toRoute(['/category/'.$category['url']])?>" class="categories-link" onclick="closeSideBar()"><?= $category['title'];?></a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>