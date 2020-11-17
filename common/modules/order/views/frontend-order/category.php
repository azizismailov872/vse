<?php 

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\widgets\OrderList;
use yii\widgets\LinkPager;
?>
<h2 class="content-header d-lg-block d-none">Актуальные заказы</h2>
<?php $form = ActiveForm::begin([
    'id' => 'create-order-form',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'validateOnType' => false,
    'validateOnChange' => false,
    'validateOnBlur' => false,
    'validateOnSubmit' => true,
    'validationUrl' => Url::toRoute(['/order/validate-form']),
    'errorCssClass' => 'error-input',
    'options' => [
        'class' => 'order-form',
        'dataPjax' => 1,
    ]
]);?>
<div class="row">
    <?= $form->field($model,'content',[
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
            'class' => 'error-message'
        ],
        'validateOnChange' => true,
    ])->textarea(['class' => 'order-form-textarea','placeholder' => 'Например: Нужен ремонт квартиры...']);?>
</div>
<?= $form->field($model,'category_id',[
    'template' => '
        <div class="col-12">
             {error}
        </div>
        <div class="col-lg-4 order-1 pl-lg-2">
            <button class="button green full order-form-button popup-open" id="new-order">Создать заказ</button>
        </div>
        <div class="col-lg-8 pr-lg-2">
            {input}
        </div>
    ',
    'options' => [
        'tag' => 'div',
        'class' => 'row justify-content-end',
    ],
    'errorOptions' => [
        'tag' => 'span',
        'class' => 'error-message'
    ],
    'validateOnChange' => true,
])->hiddenInput(['value' => $category->id])->label(false);?>
<div class="popup new-order">
    <div class="popup-content">
        <span class="popup-close fa fa-close"></span>
        <div class="popup-body">
            <div class="row">
                <div class="col-12">
                    <h3 class="new-order-header">Создайте заказ</h3>
                </div>
                <div class="col-12">
                    <p class="new-order-text">Укажите номер телефона, чтобы создать заказ</p>
                </div>
            </div>
            <?= $form->field($model,'author_phone',[
                'template' => '
                    <div class="col-12">
                        {error}
                    </div>
                    <div class="col-12">
                        <div class="input__container new-order-phone">
                            {input}
                            <i class="bx bx-phone icon"></i>
                            <div class="bg"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="button green full new-order-btn" id="create-order-btn" type="submit">Создать заказ</button>
                    </div>
                ',
                'options' => [
                    'tag' => 'div',
                    'class' => 'row',
                ],
                'errorOptions' => [
                    'tag' => 'span',
                    'class' => 'error-message',
                ],
                'validateOnChange' => true,
            ])->textInput(['class' => 'mask','placeholder' => '+996','value' => $phoneValue,'inputmode' => 'tel']);?>
        </div>
    </div>
</div>
<?php ActiveForm::end();?>
<div class="orders-list" id="orders-list">
<?php Pjax::begin(['id' => 'orders-list-pjax']);?>
    <?php if(isset($orders) && !empty($orders)) :?>
        <?= OrderList::widget(['orders' => $orders]);?>
    <?php Pjax::end();?>
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
    <?php else: ?>
        <div class="no-order">
            <h2 class="no-order-header">Нет заказов в этой категории</h2>
        </div>
    <?php endif;?>
</div>
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