<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
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
                <h2>Создать заказ</h2>
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
                        'id' => 'create-category',
                        'class' => 'form-horizontal form-label-left',
                    ],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ]
                    ],
                ]);?>
                 <?= $form->field($model,'author_name',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','placeholder' => 'Имя автора'])->label('Имя автора');?>
                <?= $form->field($model,'author_phone',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control mask','placeholder' => '+996','value' => $phoneValue])->label('Телефон автора');?>
                 <?= $form->field($model,'category_id',[
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
                ])->dropDownList($categoriesList,['class' => 'form-control','prompt' => 'Категория'])->label('Категория');?>
                 <?= $form->field($model,'content',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textarea(['class' => 'form-control','placeholder' => 'Опишите заказ ...','style' => 'width:100%;min-height: 100px;'])->label('Описание');?>
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
                <?= $form->field($model,'created_at',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->widget(DatePicker::classname(), [
                        'language' => 'ru',
                        'dateFormat' => 'dd-MM-yyyy',
                        /*'clientOptions' => ['defaultDate' => date('dd-MM-yyyy')],*/
                        'options' => ['placeholder' => 'Дата создания','class' => 'form-control'],
                ])->label('Дата создания');?>
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
