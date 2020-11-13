<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
?>
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
                    'method' => 'get',
                    'options' => [
                        'id' => 'category-filters',
                        'data-pjax' => 1,
                    ],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ]
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
                 <?= $form->field($searchModel,'title',[
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
                ])->textInput(['maxlength' => 250, 'class' => 'form-control'])->label('Название');?>
                <?= $form->field($searchModel,'url',[
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
                ])->textInput(['maxlength' => 250, 'class' => 'form-control'])->label('Ссылка');?>
                <?= $form->field($searchModel,'status',[
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
                ])->dropDownList([0 => 'Не активен',1 => 'Активен'],['class' => 'form-control','prompt' => 'Статус'])->label('Статус');?>
                <div class="form-group mt-5 button_group">
                    <div class="col-lg-10 button_group">
                       <?= Html::submitButton('Поиск', ['class' => 'btn btn-success mr-4','id' => 'search_btn']); ?>
                        <?= Html::resetButton('сбросить', ['class' => 'reset btn  btn-primary','id' => 'reset_btn' ,'type' => 'reset']); ?>
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
                <p><?= Html::a('Создать категорию',Url::toRoute(['/category/create']), ['class' => 'btn btn-success']) ?></p>
                    <?php Pjax::begin(['id' => 'category-grid']);?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'emptyText' => 'Нет категорий',
                        'summary' => 'Показано <strong>{count}</strong> категорий из <strong>{totalCount}</strong>',
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
                            'id',
                            [
                                'attribute'=>'title',
                                'format'=>'text',//raw, html
                                'label' => 'Меню',
                            ],
                            [
                                'attribute'=>'icon',
                                'format'=>'text',//raw, html
                                'label' => 'Иконка',
                                'content' => function($model)
                                {
                                    return (!empty($model['icon'])) ? $model['icon'] : 'Нет иконки';
                                }
                            ],
                            [
                                'attribute'=>'url',
                                'format'=>'url',//raw, html
                                'label' => 'Ссылка',
                            ],
                            [
                                'attribute'=>'order',
                                'format'=>'text',//raw, html
                                'label' => 'Очередность',
                            ],
                            [
                                'attribute'=>'status',
                                'format'=>'text',//raw, html
                                'label' => 'Cтатус',
                                'content' => function($model)
                                {
                                    return ($model['status'] == 0) ? 'Не активен' : 'Активен';
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

                                                    url = 'category/remove';

                                                    grid_id = '#category-grid';

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
                <?php Pjax::end();?>
            </div>
        </div>
    </div>
</div>
