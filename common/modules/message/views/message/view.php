<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\widgets\MessageButton;

?>
<a onclick="javascript:history.back();" style="cursor:pointer;" class="back-to-button">
    <span class="fas fa-chevron-left back-to-icon"></span>
    Назад
</a>
<div class="message one">
    <div class="row">
        <div class="col-auto">
            <img src="<?= $author->getImage();?>" alt="Заказчик" class="message-img">
        </div>
        <div class="col d-flex align-items-center w-100 p-lg-0">
            <div class="row justify-content-between align-items-center w-100">
                <div class="col-auto">
                    <h2 class="message-header">
                        <?= $author->getFullName();?>
                    </h2>
                </div>
                <div class="col-lg-4 d-flex justify-content-end p-lg-0">
                    <span class="message-time">
                        <?= $model->new_time($model->created_at);?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p class="message-content"><?= nl2br($model->message)?></p>
        </div>
    </div>
    <div class="row justify-content-end">
        <?= MessageButton::widget(['message' => $model]);?>
    </div>
</div>
<?php if(Yii::$app->user->getId() == $model->reciver_id) :?>
<div class="popup write-message write-message-answer">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <div class="row justify-content-center">
                <div class="col-auto text-center write-message-phone">
                    Телефон: <strong><?= $model->author->getPhone()?></strong>
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
<?php elseif(Yii::$app->user->getId() == $model->author_id) :?>
<div class="popup write-message write-message-more">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <div class="row justify-content-center">
                <div class="col-auto text-center write-message-phone">
                    Телефон: <strong><?= $model->reciver->getPhone();?></strong>
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
                        <?= $form->field($message,'reciver_id')->hiddenInput(['value' => $model->reciver->id])->label(false);?>  
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
            <h3 class="success-header">Ваш заказ опубликован !</h3>
            <div class="success-img">
                <img src="/frontend/themes/vse/img/success.png" alt="">
            </div>
        </div>
    </div>
</div>
