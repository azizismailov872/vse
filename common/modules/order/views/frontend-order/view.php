<?php 

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\widgets\OrderButton;
use common\widgets\NoBalancePopup;
use yii\widgets\ActiveForm;

if($model->canWriteMessage())
{
    $class = 'mb-10';
}
else
{
    $class = '';
}
?>
<a onclick="javascript:history.back();" style="cursor:pointer;" class="back-to-button">
    <span class="fas fa-chevron-left back-to-icon"></span>
    Назад
</a>
<div class="order one" id="<?= $model->id;?>">
    <div class="row">
        <div class="col-auto">
            <img src="<?= $model->author->getImage();?>" alt="Заказчик" class="order-img">
        </div>
        <div class="col d-flex align-items-center w-100 p-0">
            <div class="row justify-content-between align-items-center w-100">
                <div class="col-12">
                    <h2 class="order-header">
                        <?= $model->author_name;?>
                    </h2>
                </div>
                <div class="col-12">
                    <span class="order-time">
                        <?= $model->new_time($model->created_at);?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p class="order-content"><?= nl2br($model->content);?></p>
        </div>
    </div>
    <div class="row justify-content-end">
        <?= OrderButton::widget(['order' => $model]);?>
    </div>
</div>
<!-- Регистрация -->
<div class="popup register">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <div class="row">
                <div class="col-12">
                    <h3 class="register-header">Войдите, чтобы получить доступ к заказу</h3>
                </div>
                <div class="col-12">
                    <a href="<?= Url::toRoute(['/login']);?>" class="button green mb-10 full">Вход</a>
                </div>
                <div class="col-12">
                    <a href="<?= Url::toRoute(['/register']);?>" class="button green full">Регистрация</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Конец -->
<!-- Связаться -->
<div class="popup call">
    <div class="popup-content d-flex align-items-center">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="call-header">Контакты заказчика</h3>
                </div>
                <div class="col-12 call-text">
                    Телефон: <strong><?= (!empty($model->author_phone)) ? '<a class="call-link" href="tel:'.$model->author_phone.'">'.$model->author_phone.'</a>' : 'Не указан' ?></strong>
                </div>
                <?php if(!empty($model->author_phone)) :?>
                <div class="col-12">
                    <a href="tel:<?= $model->author_phone;?>" class="button green full <?= $class;?>">Позвонить</a>
                </div>
                <?php endif;?>
                <?php if($model->canWriteMessage()) :?>
                <div class="col-12">
                    <a class="button yellow full popup-open" id="write-message">Написать</a>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<!-- Конец -->
<!-- Нет баланса -->
<?= NoBalancePopup::widget();?>
<!-- Конец -->
<!-- Сообщение -->
<?php if($model->canWriteMessage()) :?>
<div class="popup write-message">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <div class="row justify-content-center">
                <div class="col-auto text-center write-message-phone">
                    Телефон: <strong><?= $model->author_phone?></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'write-message-form',
                    'errorCssClass' => 'error-input',
                    'enableClientValidation' => false,
                    'enableClientValidation' => true,
                    'validationUrl' => Url::toRoute(['/message/validate']),
                    'options' => [
                        'class' => 'write-message-form',
                    ],
                ]);?>
                <div class="row">
                    <?= $form->field($message,'message',[
                        'template' => '
                            {error}
                            {input}
                            
                        ',
                        'options' => [
                            'tag' => 'div',
                            'class' => 'col-12'
                        ],
                        'errorOptions' => [
                            'tag' => 'span',
                            'class' => 'message-form-error'
                        ],
                    ])->textarea(['class' => 'write-message-textarea','placeholder' => 'Напишите сообщение']);?>
                    <?= $form->field($message,'reciver_id')->hiddenInput(['value' => $model->author->id])->label(false);?>  
                    <div class="col-12 d-flex justify-content-center">
                        <?= Html::submitButton('Отправить',['class' => 'button yellow write-message-btn']);?>
                    </div>
                </div>
                <?php ActiveForm::end();?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="popup success">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <h3 class="success-header">Сообщение успешно отправлено</h3>
            <div class="success-img">
                <img src="/frontend/themes/vse/img/success.png" alt="">
            </div>
        </div>
    </div>
</div>
<div class="popup no-active">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <h1 class="no-active-header">Заказ не актуален</h1>
        </div>
    </div>
</div>
