<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2><?= Html::encode($this->title)?></h2>
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
                         'class' => 'form-horizontal form-label-left',
                         'id' => 'create-menu'
                    ],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ]
                    ],
                ]);?>
                <?= $form->field($model,'title',[
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
                ])->textInput(['class' => 'form-control','placeholder' => 'Введите название для меню...'])->label('Название');?>
                 <?= $form->field($model,'parent_id',[
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
                ])->dropDownList($menusList,['prompt' => 'Выбрать','class' => 'form-control'])->label('Родительское меню');?>
                 <?= $form->field($model,'url',[
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
                ])->textInput(['class' => 'form-control','placeholder' => 'Введите ссылку для меню'])->label('Ссылка');?>
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
                ])->dropDownList($menuCategoriesList,['prompt' => 'Выбрать','class' => 'form-control'])->label('Категория');?>
                 <?= $form->field($model,'icon',[
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
                ])->textInput(['class' => 'form-control','placeholder' => 'Класс для иконки меню...'])->label('Иконка');?>
                 <?= $form->field($model,'status',[
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
                ])->checkbox(['class' => 'js-switch','uncheck' => 0, 'check' => 1])->label('Опубликовано');?>
                <div class="ln_solid"></div>
                <div class="form-group row">
                    <div class="col-md-9 col-sm-9 offset-md-3">
                        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']); ?>
                        <?= Html::resetButton('Сбросить', ['class' => 'reset btn  btn-primary','type' => 'reset']); ?>
                    </div>
                </div>
                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
</div>