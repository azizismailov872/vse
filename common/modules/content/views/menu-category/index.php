<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-12">
        <div class="x_panel">
            <div class="x_title">
                <h3>Фильтрация</h3>
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
                    'method' => 'post',
                    'options' => [
                        'id' => 'filters-form',
                        'data-pjax' => 1
                    ],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ]
                    ],
                ]) ?>
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
                ])->textInput(['class' => 'form-control'])?>
                <div class="form-group mt-4 button_group">
                    <div class="col-lg-6 button_group">
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
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p><?= Html::a('Создать категорию меню', ['create'], ['class' => 'btn btn-success']) ?></p>
                <?php Pjax::begin(['id' => 'menu-categories-grid']);?>
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
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end();?>
            </div>
        </div>
    </div>
</div>
