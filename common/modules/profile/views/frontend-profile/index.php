<?php 

use common\widgets\OrderList;
use common\widgets\PlusBalancePopup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

?>
<div class="profile one">
    <a href="<?= Url::toRoute(['/profile/edit/'.$user->id]);?>" class="fa fa-cog profile-edit-link"></a>
    <div class="row">
        <div class="col-lg-auto col-12 d-flex d-lg-block justify-content-center justify-content-lg-start pr-lg-2 align-items-center">
            <img src="<?= $user->getImage();?>" alt="Фото профиля" class="profile-img">
        </div>
        <div class="col d-flex align-items-center pl-lg-2">
            <div class="row justify-content-center justify-content-lg-start">
                <div class="col-12 d-flex d-lg-block  justify-content-center justify-content-lg-start">
                    <h2 class="profile-name">
                       <?= $user->getFullName();?>
                    </h2>
                </div>
                <div class="col-12 d-flex d-lg-block  justify-content-center justify-content-lg-start">
                    <a href="#" class="profile-balance popup-open" id="plus-balance">Баланс: <span class="balance"><?= $user->balance;?><u>с</u></span><span class="plus-icon fa fa-plus-circle"></span></a>
                </div>
                <div class="col-12 d-flex d-lg-block  justify-content-center justify-content-lg-start">
                    <?php if($user->hasPhone()) :?>
                        <a href="tel:<?= $user->getPhone()?>" class="profile-phone" style="cursor:pointer;">Телефон: <?= $user->getPhone();?></a>
                    <?php else :?>
                        <a class="profile-phone" style="cursor:pointer;">Телефон: <?= $user->getPhone();?></a>
                    <?php endif;?>

                </div>
                <div class="col-10 col-sm-10 col-md-6 col-lg-6">
                    <button class="button green full popup-open" id="plus-balance">Пополнить баланс</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="profile-description">
                <h2 class="profile-description-header text-center text-lg-left">
                    Описание
                </h2>
                <p class="profile-description-text">
                    <?= (!empty($user->description)) ? $user->description : 'Нет описания';?>
                </p>
                <hr>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="order-header">
                Мои заказы
            </h2>
            <div class="orders-list">
            <?php Pjax::begin(['id' => 'orders-list']);?>
            <?php if(isset($orders) && !empty($orders)) :?>
               <?= OrderList::widget(['orders' => $orders,'profile' => true]);?>
            <?php else: ?>
                <div class="no-order">
                    <h2 class="no-order-header">Нет заказов</h2>
                </div>
            <?php endif;?>
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'activePageCssClass' => 'active',
                    'maxButtonCount' => 5,
                    'options' => ['class' => 'pagination'],
                    'linkContainerOptions' => ['class' => 'pager'],
                    'linkOptions' => [
                        'class' => 'pager-link',
                    ], 
                ]); ?>
            <?php Pjax::end();?>
            </div>
        </div>
    </div>
</div>
<?= PlusBalancePopup::widget();?>