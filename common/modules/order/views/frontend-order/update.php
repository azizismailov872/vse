<?php
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h2 class="content-header d-lg-block d-none">Редактировать заказ</h2>
<div class="content">
    <?php $form = ActiveForm::begin([
        'id' => 'update-order-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'errorCssClass' => 'error-input',
        'options' => [
            'class' => 'order-form',
        ],
    ])?>
    <div class="row">
        <div class="col-12">
           <?php if($update->hasErrors()):?>
                <?php foreach ($update->getErrors() as $key => $value):?>
                    <div class="alert alert-danger" role="alert">
                        <?= $value[0];?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
    <div class="row">
        <?= $form->field($update,'content',[
            'template' => '
                {input}
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-12'
            ],
        ])->textarea(['class' => 'order-form-textarea','placeholder' => 'Опишите ваш заказ. Например: Нужен ремонт квартиры...'])->label(false);?>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="edit-order-header">
                Имя
            </h2>
        </div>
        <?= $form->field($update,'author_name',[
            'template' => '
                <div class="input__container edit-order-name">
                    {input}
                    <i class="bx bx-user icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-12'
            ],
        ])->textInput(['class' => false,'placeholder' => 'Имя'])->label(false);?>
        <div class="col-12">
            <h2 class="edit-order-header">
                Телефон
            </h2>
        </div>
        <?= $form->field($update,'author_phone',[
            'template' => '
                <div class="input__container edit-order-phone">
                    {input}
                    <i class="bx bx-phone icon"></i>
                    <div class="bg"></div>
                </div>
            ',
            'options' => [
                'tag' => 'div',
                'class' => 'col-12'
            ],
        ])->textInput(['class' => 'mask','placeholder' => '+996'])->label(false);?>
    </div>
    <div class="row justify-content-end">
        <div class="col-lg-4 order-1 pl-lg-2">
            <?= Html::submitButton('Изменить',['class' => 'button green full order-form-button']);?>
        </div>
        <?= $form->field($update,'category_id',[
                'template' => '
                    {input}
                ',
                'options' => [
                    'tag' => 'div',
                    'class' => 'col-lg-8'
                ],
            ])->dropDownList($categoriesList,['class' => 'order-form-select custom-select','prompt' => 'Выберите категорию'])->label(false);?>
    </div>
    <?php ActiveForm::end();?>
    <div class="popup success">
        <div class="popup-content">
            <span class="popup-close fa fa-close"></span>
            <div class="popup-body">
                <h3 class="success-header">Ваш заказ опубликован</h3>
                <div class="success-img">
                    <img src="/frontend/themes/vse/img/success.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
