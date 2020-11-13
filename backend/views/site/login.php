<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'login-form',
    ],
    'fieldConfig' => [
        'options' => [
            'tag' => false,
        ]
    ],
]);?>
<div class="row">
    <?php if($model->hasErrors()):?>
        <?php foreach ($model->getErrors() as $key => $value):?>
            <div class="alert alert-danger w-100 text-center" role="alert">
                <?= $value[0];?>
            </div>
        <?php endforeach;?>
    <?php endif;?>
    <div class="col-12 d-flex justify-content-center">
        <h3 class="login-header">
            Панель администратора
        </h3>
    </div>
</div>
<div class="row">
    <?= $form->field($model,'login',[
        'template' => '
            <div class="col-12">
                 <div class="input__container login-input">
                    {input}
                    <i class="bx bx-envelope icon"></i>
                    <div class="bg"></div>
                </div>
            </div>
        '
    ])->textInput(['class' => false,'placeholder' => 'Почта']);?>
    <?= $form->field($model,'password',[
        'template' => '
            <div class="col-12">
                 <div class="input__container login-input">
                    {input}
                    <i class="bx bx-lock icon"></i>
                    <div class="bg"></div>
                </div>
            </div>
        '
    ])->passwordInput(['class' => false,'placeholder' => 'Пароль']);?>
    <div class="col-12">
        <?= Html::submitButton('Вход',['class' => 'button green full login-btn']);?>
    </div>
</div>
<?php ActiveForm::end();?>