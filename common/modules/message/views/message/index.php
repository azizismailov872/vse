<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\PlusBalancePopup;
use yii\widgets\LinkPager;
?>
<div class="profile one">
    <a href="<?= Url::toRoute(['/profile/edit/'.$user->id]);?>" class="fa fa-cog profile-edit-link"></a>
    <div class="row">
        <div class="col-lg-auto col-12 d-flex d-lg-block justify-content-center justify-content-lg-start pr-2">
            <img src="<?= $user->getImage();?>" alt="Фото профиля" class="profile-img">
        </div>
        <div class="col d-flex align-items-center pl-2">
            <div class="row justify-content-center justify-content-lg-start">
                <div class="col-12 d-flex d-lg-block  justify-content-center justify-content-lg-start">
                    <h2 class="profile-name">
                       <?= $user->getFullName();?>
                    </h2>
                </div>
                <div class="col-12 d-flex d-lg-block  justify-content-center justify-content-lg-start">
                    <a href="" class="profile-balance popup-open" id="plus-balance">Баланс: <span class="balance"><?= $user->balance;?><u>с</u></span><span class="plus-icon fa fa-plus-circle"></span></a>
                </div>
                <div class="col-12 d-flex d-lg-block  justify-content-center justify-content-lg-start">
                    <a href="<?= $user->getPhone();?>" class="profile-phone">Телефон: <?= $user->getPhone();?></a>
                </div>
                <div class="col-8 col-sm-8 col-md-6 col-lg-6">
                    <button class="button green full popup-open" id="plus-balance">Пополнить баланс</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row messages-content">
        <div class="col-12">
            <ul class="nav nav-tabs">
                <li class="nav-item message-tab-item">
                    <a class="nav-link active" data-toggle="tab" href="#inbox">Входящие</a>
                </li>
                <li class="nav-item message-tab-item">
                    <a class="nav-link" data-toggle="tab" href="#outbox">Отправленные</a>
                </li>
            </ul>
        </div>
        <div class="col-12">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="inbox">
                    <div class="messages-list">
                    <?php Pjax::begin(['id' => 'inboxMessagesList']);?>
                        <?php if(isset($inboxMessages) && !empty($inboxMessages)) :?>
                            <?php foreach($inboxMessages as $inbox) :?>
                                <!-- Message -->
                                <div class="message" id="<?= $inbox->id?>" onclick="openMessage(this)">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-lg-auto">
                                            <a href="<?= Url::toRoute(['/profile/message/'.$inbox->id]);?>" class="message-header"><?= $inbox->author->getUsername();?></a>
                                        </div>
                                        <div class="col-lg-4 d-lg-flex justify-content-end ">
                                            <span class="message-time"><?= $inbox->new_time($inbox->created_at);?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="message-content">
                                                <?= $inbox->substrContent();?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Message end -->
                            <?php endforeach;?>
                            <?= LinkPager::widget([
                                'pagination' => $inboxPagination,
                                'activePageCssClass' => 'active',
                                'maxButtonCount' => 5,
                                'options' => ['class' => 'pagination'],
                                'linkContainerOptions' => ['class' => 'pager'],
                                'linkOptions' => [
                                    'class' => 'pager-link',
                                ], 
                            ]); ?>
                        <?php else :?>
                        <div class="no-order d-flex justify-content-center align-items-center">
                            <h2 class="no-order-header">Нет входящих сообщений</h2>
                        </div>
                        <?php endif;?>
                    <?php Pjax::end();?>
                    </div>
                </div>
                <div class="tab-pane fade show" id="outbox">
                    <div class="messages-list">
                    <?php Pjax::begin(['id' => 'outboxMessagesList']);?>
                        <?php if(isset($outboxMessages) && !empty($outboxMessages)) :?>
                            <?php foreach($outboxMessages as $outbox) :?>
                                <!-- Message -->
                                <div class="message" id="<?= $outbox->id;?>" onclick="openMessage(this)">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-lg-auto">
                                            <a href="<?= Url::toRoute(['/profile/message/'.$outbox->id]);?>" class="message-header"><?= $outbox->reciver->getUsername();?></a>
                                        </div>
                                        <div class="col-lg-4 d-lg-flex justify-content-end ">
                                            <span class="message-time"><?= $outbox->new_time($outbox->created_at);?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="message-content">
                                                <?= $outbox->substrContent();?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Message end -->
                            <?php endforeach;?>
                            <?= LinkPager::widget([
                                'pagination' => $outboxPagination,
                                'activePageCssClass' => 'active',
                                'maxButtonCount' => 5,
                                'options' => ['class' => 'pagination'],
                                'linkContainerOptions' => ['class' => 'pager'],
                                'linkOptions' => [
                                    'class' => 'pager-link',
                                ], 
                            ]); ?>
                        <?php else:?>
                             <div class="no-order d-flex justify-content-center align-items-center">
                                <h2 class="no-order-header">Нет отправленных сообщений</h2>
                            </div>
                        <?php endif;?>
                    <?php Pjax::end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= PlusBalancePopup::widget();?>