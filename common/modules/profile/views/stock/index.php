<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>
<div class="row">
    <div class="col-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Фильтрация акций</h3>
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
                        'id' => 'filters-form',
                        'enableClientValidation' => false,
                        'data-pjax' => true,
                    ],
                ]);?>
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
                ])->textInput(['class' => 'form-control']);?>
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
                <?= $form->field($searchModel,'status',[
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
                ])->dropDownList([0 => 'Не активен',1 => 'Активен'],['class' => 'form-control','prompt' => 'Статус'])->label('Статус');?>
                    <div class="form-group  button_group">
                        <div class="col-lg-12 mt-2 button_group">
                           <?= Html::submitButton('Поиск', ['class' => 'btn btn-success mr-4','id' => 'search_btn']); ?>
                            <?= Html::resetButton('Сбросить', ['class' => 'reset btn  btn-primary','id' => 'reset_btn' ,'type' => 'reset']); ?>
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
                <h3><?= Html::encode($this->title);?></h3>
                 <?= Html::a('Создать акцию', ['create'], ['class' => 'btn btn-success']) ?>
                 <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin([
                           'id' => 'stocks-grid',
                        ]); ?>
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
                    'columns' => [
                        'id',
                        [
                            'attribute'=>'title',
                            'format'=>'text',//raw, html
                            'label' => 'Название',
                            
                        ],
                        [   
                            'attribute'=>'status',
                            'format'=> 'text',//raw, html
                            'label' => 'Статус',
                            'content'=>function($model)
                            {
                                return ($model->status == 1) ? 'Активен' : ' Не активен';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}{delete}',
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

                                                url = 'stock/delete';

                                                grid_id = '#stocks-grid';

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
       

    

