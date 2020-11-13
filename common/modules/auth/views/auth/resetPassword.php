<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'errorCssClass' => 'error-input',
    'options' => [
        'class' => 'login-form',
    ],
]);?>
<div class="row">
    <?php if($model->hasErrors()):?>
        <?php foreach ($model->getErrors() as $key => $value):?>
            <div class="alert alert-danger w-100" role="alert">
                <?= $value[0];?>
            </div>
        <?php endforeach;?>
    <?php endif;?>
    <div class="col-12 d-flex justify-content-center justify-content-lg-start">
        <h3 class="login-header">
            Восстановление пароля
        </h3>
    </div>
</div>
<div class="row">
    <?= $form->field($model,'password',[
        'template' => '
             <div class="input__container login-input">
                {input}
                <i class="bx bx-lock icon"></i>
                <div class="bg"></div>
            </div>
        ',
        'options' => [
            'tag' => 'div',
            'class' => 'col-12'
        ]
    ])->passwordInput(['class' => false,'placeholder' => 'Новый пароль']);?>
    <div class="col-12">
        <?= Html::submitButton('Изменить пароль',['class' => 'button green full login-btn']);?>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <a href="<?= Url::toRoute(['/login']);?>" class="login-link">Войти в аккаунт</a>
    </div>
</div>
<?php ActiveForm::end();?>