<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <?php if($model->hasErrors()):?>
                <?php foreach ($model->getErrors() as $key => $value):?>
                    <div class="alert alert-danger" role="alert">
                        <?= $model->getAttributeLabel($key).': '.$value[0];?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
            <div class="x_title">
                <h2>Создать пользователя</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'id' => 'create-user',
                        'class' => 'form-horizontal form-label-left',
                    ],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ]
                    ],
                ]);?>
                 <?= $form->field($model,'email',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','placeholder' => 'user@example'])->label('Почта (Обязательно)');?>
                 <?= $form->field($model,'username',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                            {error}
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','placeholder' => 'Имя'])->label('Имя');?>
                 <?= $form->field($model,'surname',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','placeholder' => 'Фамилия'])->label('Фамилия');?>
                <?= $form->field($model,'password',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->passwordInput(['class' => 'form-control','placeholder' => 'Пароль'])->label('Пароль');?>
                <?= $form->field($model,'description',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textarea(['class' => 'form-control','placeholder' => 'Описание','rows' => 6])->label('Описание');?>
                <?= $form->field($model,'phone',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control phone__mask','placeholder' => '+996'])->label('Телефон');?>
                <?= $form->field($model,'balance',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','placeholder' => '0','type' => 'integer'])->label('Баланс');?>
                <?= $form->field($model,'status',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->checkbox(['class' => 'js-switch','uncheck' => 0, 'check' => 1])->label('Статус');?>
                <?= $form->field($model,'image',[
                    'template' => '
                        <div class="item form-group justify-content-center">
                            <div class="col-md-6 col-sm-6 input__container">
                               {input}
                               {label}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-md-6 col-sm-6 text-center input__file__button'],
                ])->fileInput(['class' => 'input__file'])->label('Добавить фото');?>
                <div class="ln_solid"></div>
                <div class="form-group row">
                    <div class="col-md-9 col-sm-9 offset-md-3">
                        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']); ?>
                        <?= Html::resetButton('Собросить', ['class' => 'reset btn  btn-primary','type' => 'reset']); ?>
                    </div>
                </div>
                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
</div>
