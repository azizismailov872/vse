<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\modules\content\models\Menu;
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
                        'id' => 'menu-filters',
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
                 <?= $form->field($searchModel,'category_id',[
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
                ])->dropDownList($categoriesList,['class' => 'form-control','prompt' => 'Выберите'])->label('Категория');?>
                 <?= $form->field($searchModel,'url',[
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
                ])->textInput(['maxlength' => 250, 'class' => 'form-control'])->label('Ссылка');?>
                <?= $form->field($searchModel,'parent_id',[
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
                ])->dropDownList($menuList,['class' => 'form-control','prompt' => 'Выберите'])->label('Родительское меню');?>
                <div class="form-group mt-4 button_group">
                    <div class="col-lg-6 button_group">
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
                <p><?= Html::a('Создать меню',Url::toRoute(['/menu/create']), ['class' => 'btn btn-success']) ?></p>
                    <?php Pjax::begin(['id' => 'menu-grid']);?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
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
                                'attribute'=>'parent_id',
                                'format'=>'text',//raw, html
                                'label' => 'Родительское меню',
                                'content'=>function($model)
                                {
                                    return ($model->parent_id !== 0) ? Menu::getParentMenuName($model->parent_id) : 'Нет родителя';
                                }
                            ],
                            [
                                'attribute'=>'category_id',
                                'format'=>'text',//raw, html
                                'label' => 'Категория',
                                'content'=>function($model)
                                {
                                    return ($model->category_id !== 0) ? $model->category->title : 'Нет категории';
                                }
                            ],
                            [
                                'attribute'=>'url',
                                'format'=>'url',//raw, html
                                'label' => 'Ссылка',
                            ],
                            [
                                'attribute'=>'status',
                                'format'=>'text',//raw, html
                                'label' => 'Cтатус',
                                'content' => function($model)
                                {
                                    return ($model->status !== 0) ? 'Активен' : 'Не активен';
                                }
                            ],
                            //'status',
                            //'icon',

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
                                            return (Yii::$app->user->getId() == $model->id) ? true : false;
                                        }
                                    },
                                    'delete' => function ($model) {
                                        if(Yii::$app->user->can('admin'))
                                        {
                                            return true;
                                        }
                                        else
                                        {
                                            return (Yii::$app->user->getId() == $model->id) ? true : false;
                                        }
                                    },
                                ],
                                'buttons' => [
                                    'delete' => function($url,$model){
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '', [
                                            'id' => $model->id,
                                            'class' => 'delete-static',
                                            'onclick' => "
                                                if(confirm('Вы уверены что хотите удалить запись?'))
                                                {   

                                                    id = $(this).attr('id');
                                                    data = {id:id};

                                                    url = 'menu/remove';

                                                    grid_id = '#menu-grid';

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
