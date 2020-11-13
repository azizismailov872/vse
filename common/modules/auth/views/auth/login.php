<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
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
            Вход
        </h3>
    </div>
</div>
<div class="row">
    <?= $form->field($model,'login',[
        'template' => '
             <div class="input__container login-input">
                {input}
                <i class="bx bx-envelope icon"></i>
                <div class="bg"></div>
            </div>
        ',
        'options' => [
            'tag' => 'div',
            'class' => 'col-12'
        ]
    ])->textInput(['class' => false,'placeholder' => 'Почта']);?>
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
    ])->passwordInput(['class' => false,'placeholder' => 'Пароль']);?>
    <div class="col-12">
        <?= Html::submitButton('Вход',['class' => 'button green full login-btn']);?>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <a href="<?= Url::toRoute(['/register']);?>" class="login-link">Регистрация</a>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <a href="<?= Url::toRoute(['/request-password-reset']);?>" class="login-link">Забыли пароль ?</a>
    </div>
</div>
<?php ActiveForm::end();?>