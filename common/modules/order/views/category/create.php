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
                <h2>Создать категорию</h2>
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
                 <?= $form->field($model,'title',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','placeholder' => 'Категория...'])->label('Название');?>
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
                ])->textInput(['class' => 'form-control','placeholder' => 'marketing'])->label('Ссылка(eng)');?>
                 <?= $form->field($model,'order',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','type' => 'integer','placeholder' => '1,2,3'])->label('Очередность');?>
                <?= $form->field($model,'icon',[
                    'template' => '
                        <div class="item form-group">
                            {label}
                            <div class="col-md-6 col-sm-6 ">
                               {input}
                            </div>
                        </div>
                    ',
                    'labelOptions' => ['class' => 'col-form-label col-md-3 col-sm-3 label-align'],
                ])->textInput(['class' => 'form-control','placeholder' => 'fa fa-icon'])->label('Класс иконки');?>
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
