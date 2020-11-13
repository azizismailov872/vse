<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
?>
<div class="row">
    
</div>
<div class="row">
    <div class="col-12">
        <div class="x_panel">
            <div class="x_title">
                <h1>Фильтрация</h1>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin([
                    'action'=>['index'],
                    'id' => 'search_form',
                    'method' => 'get',
                    'options' => [
                        'id' => 'filters-form',
                        'enableClientValidation' => false,
                        'data-pjax' => true,
                    ],
                ]);
                ?>
                <?= $form->field($searchModel,'id',[
                    'template' => '
                            <div class="col-lg-4">
                               <div class="input-title">
                                    {label}
                                </div>
                                <div class="form-input">
                                    {input}
                                </div>  
                            </div>
                    ',
                ])->textInput(['class' => 'form-control'])?>
                <?= $form->field($searchModel,'username',[
                    'template' => '
                            <div class="col-lg-4">
                               <div class="input-title">
                                    {label}
                                </div>
                                <div class="form-input">
                                    {input}
                                </div>
                            </div>
                    ',
                ])->textInput(['maxlength' => 250, 'class' => 'form-control'])->label('Имя пользователя');?>
                <?= $form->field($searchModel,'email',[
                    'template' => '
                            <div class="col-lg-4">
                               <div class="input-title">
                                    {label}
                                </div>
                                <div class="form-input">
                                    {input}
                                </div>
                            </div>
                    ',
                ])->textInput(['maxlength' => 250, 'class' => 'form-control'])->label('Почта');?>
                 <?= $form->field($searchModel,'surname',[
                    'template' => '
                            <div class="col-lg-4 mt-2">
                               <div class="input-title">
                                    {label}
                                </div>
                                <div class="form-input">
                                    {input}
                                </div>
                            </div>
                    ',
                ])->textInput(['maxlength' => 250, 'class' => 'form-control'])->label('Фамилия пользователя');?>
                 <?= $form->field($searchModel,'phone',[
                    'template' => '
                            <div class="col-lg-4 mt-2">
                               <div class="input-title">
                                    {label}
                                </div>
                                <div class="form-input">
                                    {input}
                                </div>
                            </div>
                    ',
                ])->textInput(['maxlength' => 250, 'class' => 'form-control mask'])->label('Телефон');?>
                <?= $form->field($searchModel,'created_at',[
                    'template' => '
                            <div class="col-lg-4 mt-2">
                               <div class="input-title">
                                    {label}
                                </div>
                                <div class="form-input">
                                    {input}
                                </div>
                            </div>
                    ',
                ])->widget(DatePicker::classname(), [
                        'language' => 'ru',
                        'dateFormat' => 'dd-MM-yyyy',
                        /*'clientOptions' => ['defaultDate' => date('dd-MM-yyyy')],*/
                        'options' => ['placeholder' => 'Дата регистрации','class' => 'form-control','autocomplete' => 'off'],
                ])->label('Дата регистрации'); ?>
                <div class="form-group mt-4 button_group">
                    <div class="col-lg-12 button_group">
                       <?= Html::submitButton('Поиск', ['class' => 'btn btn-success mr-4','id' => 'search_btn']); ?>
                        <?= Html::resetButton('Cбросить', ['class' => 'reset btn  btn-primary','id' => 'reset_btn' ,'type' => 'reset']); ?>
                    </div>
                </div>
                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
</div> 
<div class="row">
    <div class="col-12">
        <div class="x_panel">
            <div class="x_title">
                <h1><?= Html::encode($this->title) ?></h1>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                    <p>
                        <?= Html::a('Создать пользователя',Url::toRoute(['/user/create']), ['class' => 'btn btn-success']) ?>
                    </p>
                    <?php Pjax::begin(['id' => 'users-grid']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'emptyText' => 'Нет пользователей',
                        'summary' => 'Показано <strong>{count}</strong> пользователей из <strong>{totalCount}</strong>',
                        'pager' => [
                                'options'=>['class'=>'pagination'], 
                                'firstPageCssClass'=>'first',   
                                'lastPageCssClass'=>'last',    
                                'maxButtonCount'=>10,   
                                'linkOptions' => ['class' => 'page-link'],
                                'activePageCssClass' => 'active',
                                'prevPageCssClass' => 'prev',
                                'nextPageCssClass' => 'next',
                            ],
                        //'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'format' => 'text',
                                'label' => 'ID',
                            ],
                            [
                                'attribute'=>'username',
                                'format'=>'text',//raw, html
                                'label' => 'Имя',
                                'content'=>function($model)
                                {
                                    return (!empty($model['username'])) ? $model['username'] : 'Не указано';
                                }
                            ],
                            [
                                'attribute'=> 'email',
                                'format'=>'text',//raw, html
                                'label' => 'Почта',
                                'content'=>function($model)
                                {
                                    return (!empty($model['email'])) ? $model['email'] : 'Нет почты';
                                }
                            ],
                            [
                                'attribute'=> 'surname',
                                'format'=>'text',//raw, html
                                'label' => 'Фамилия',
                                'content'=>function($model)
                                {
                                    return (!empty($model['email'])) ? $model['email'] : 'Не указано';
                                }
                            ],
                            [
                                'attribute' => 'phone',
                                'format' => 'url',
                                'label' => 'Телефон',
                                'content' => function($model){
                                    return (!empty($model['phone'])) ? $model['phone'] : 'Не указан';
                                }
                            ],
                            [
                                'attribute'=>'created_at',
                                'format'=>['html'],//raw, html
                                'label' => 'Дата создания',
                                'content' => function($model)
                                {
                                    return Yii::$app->formatter->asDate($model['created_at']).' <strong>'.Yii::$app->formatter->asTime($model['created_at'],'H:m').'</strong>';
                                }
                            ],
                            [
                                'attribute'=>'balance',
                                'format'=>'text',//raw, html
                                'label' => 'Баланс',
                                'content' => function($model)
                                {
                                    return $model['balance'].' <u>сом</u>';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{update}{delete}',
                                'visibleButtons' => [
                                    'update' => function ($model) {
                                        if(Yii::$app->user->can('admin'))
                                        {
                                            return true;
                                        }
                                        else
                                        {
                                            return (Yii::$app->user->getId() == $model['id']) ? true : false;
                                        }
                                    },
                                    'delete' => function ($model) {
                                        if($model['username'] == 'Без автора' or $model['email'] == 'vseinfo.kg@gmail.com')
                                        {
                                            return false;
                                        }

                                        if(Yii::$app->user->can('admin'))
                                        {
                                            return true;
                                        }
                                        else
                                        {
                                            return (Yii::$app->user->getId() == $model['id']) ? true : false;
                                        }
                                    },
                                ],
                                'buttons' => [
                                    'delete' => function($url,$model){
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '', [
                                            'id' => $model['id'],
                                            'class' => 'delete-static',
                                            'onclick' => "
                                                if(confirm('Вы уверены что хотите удалить запись?'))
                                                {   

                                                    id = $(this).attr('id');
                                                    data = {id:id};

                                                    url = 'user/remove';

                                                    grid_id = '#users-grid';

                                                    make_action(url,data,grid_id);
                                                    
                                                    return false;
                                                }
                                            ",
                                        ]);
                                    }
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
