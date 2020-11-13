<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpres\Url;
?>
<div class="profile one">
    <?php $form = ActiveForm::begin([
        'id' => 'update-profile',
        'enableClientValidation' => false,
        'options' => [
            'class' => 'edit-profile-form'
        ],
        'errorCssClass' => 'error-input'
    ]) ;?>
    <div class="row justify-content-center">
        <div class="col-12">
            <?php if($update->hasErrors()):?>
                <?php foreach ($update->getErrors() as $key => $value):?>
                    <div class="alert alert-danger">
                        <?= $value[0];?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <div class="col-12 d-flex justify-content-center">
        <?php Pjax::begin(['id' => 'user-photo']);?>
            <img src="<?= $model->getImage();?>" alt="Фото профиля" class="profile-img mb-2">
        <?php Pjax::end();?>
        </div>
        <div class="col-12">
            <?= $form->field($update,'image',[
                'template' => '
                    <div class="col-12 d-flex justify-content-center">
                        <button type="button" class="button red mb-10 w-lg-50 w-100 delete-photo-btn" id="'.$model->id.'">Удалить фото</button>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="upload__container">
                            {label}
                            {input}
                        </div>
                    </div>',
                'labelOptions' => ['class' => 'button green w-lg-50 w-100'],
                'options' => [
                    'tag' => 'div',
                    'class' => 'row'
                ]
            ])->fileInput(['class' => 'input__file'])->label('Добавить фото');?>
        </div>
    </div>
    <div class="row">
        <?= $form->field($update,'username',[
            'template'  => '
                <div class="input__container">
                    {input}
                    <i class="bx bx-user icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-lg-6',
            ],
        ])->textInput(['class' => false,'placeholder' => 'Имя']);?> 
        <?= $form->field($update,'surname',[
            'template'  => '
                <div class="input__container">
                    {input}
                    <i class="bx bx-user icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-lg-6',
            ],
        ])->textInput(['class' => false,'placeholder' => 'Фамилия']);?> 
    </div>
    <div class="row">
        <?= $form->field($update,'phone',[
            'template' => '
                <div class="input__container">
                    {input}
                    <i class="bx bx-phone icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-lg-6',
            ]
        ])->textInput(['class' => 'mask','placeholder' => '+996']);?>
        <?= $form->field($update,'email',[
            'template' => '
                <div class="input__container">
                    {input}
                    <i class="bx bx-envelope icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-lg-6',
            ],
        ])->textInput(['class' => false,'placeholder' => 'user@gmail.com']);?>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="edit-profile-password-header">Изменить пароль</h2>
        </div>
        <?= $form->field($update,'oldPassword',[
            'template' => '
                <div class="input__container">
                    {input}
                    <i class="bx bx-lock icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-lg-6',
            ],
        ])->passwordInput(['class' => false,'placeholder' => 'Старый пароль']);?>
        <?= $form->field($update,'newPassword',[
            'template' => '
                <div class="input__container">
                    {input}
                    <i class="bx bx-lock icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-lg-6',
            ],
        ])->passwordInput(['class' => false,'placeholder' => 'Новый пароль']);?>
    </div>
    <div class="row">
         <div class="col-12">
            <h2 class="edit-description-header">
                Описание
            </h2>
        </div>
        <?= $form->field($update,'description',[
            'template' => '
                {input}
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-12',
            ],
        ])->textarea(['class' => 'edit-profile-textarea','placeholder' => 'Описание профиля']);?>
    </div>
    <div class="row">
        <div class="col-12">
            <?= Html::submitButton('Сохранить',['class' => 'button full green mt-2']);?>
        </div>
    </div>
    <?php ActiveForm::end();?>
</div>