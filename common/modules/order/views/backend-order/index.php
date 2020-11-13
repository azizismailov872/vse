<?php

use common\models\User;
use common\modules\order\models\Category;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

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
                        'id' => 'filters-form',
                        'enableClientValidation' => false,
                        'data-pjax' => true,
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
                ])->dropDownList($categoriesList,['prompt' => 'Категория','class' => 'form-control'])->label('Категория');?>
                <?= $form->field($searchModel,'author_name',[
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
                ])->textInput(['class' => 'form-control'])->label('Имя автора');?>
                <?= $form->field($searchModel,'author_phone',[
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
                ])->textInput(['class' => 'form-control mask'])->label('Телефон автора');?>
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
                ])->dropDownList([0 => 'Не активен',1 => 'Активен'],['prompt' => 'Статус','class' => 'form-control'])->label('Статус');?>
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
                        'options' => ['placeholder' => 'Дата создания','class' => 'form-control','autocomplete' => 'off'],
                ])->label('Дата создания'); ?>
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
                <h1><?= Html::encode($this->title);?></h1>
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
                    <?= Html::a('Создать заказ',Url::toRoute(['/order/create']),['class' => 'btn btn-success']) ?>
                </p>

                <?php Pjax::begin(['id' => 'orders-grid']); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => 'Нет заказов',
                    'summary' => 'Показано <strong>{count}</strong> заказов из <strong>{totalCount}</strong>',
                    'pager' => 
                    [
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
                        [
                            'attribute' => 'author_id',
                            'format' => 'html',
                            'label' => 'Автор',
                            'content' => function($model)
                            {   
                                
                                $author = User::find()->where(['id' => $model['author_id']])->asArray()->one();
                            
                                return (!empty($author['username'])) ? Html::a($author['username'],Url::toRoute(['/user/view/'.$author['id']]),['target' => '_blank']) : $author['email'];
                            }
                        ],
                        [
                            'attribute' => 'category_id',
                            'format' => 'html',
                            'label' => 'Категория',
                            'content' => function($model)
                            {   
                                $category = Category::find()->where(['id' => $model['category_id']])->asArray()->one();

                                return (!empty($category)) ? Html::a($category['title'],Url::toRoute(['/category/view/'.$category['id']]),['target' => '_blank']) : 'Нет категории';
                            }
                        ],
                        [
                            'attribute' => 'content',
                            'format' => 'text',
                            'label' => 'Заказ',
                            'content' => function($model)
                            {   
                                $content = mb_substr(trim($model['content']),0,40);
                                return $content." ...";
                            }
                        ],
                        [
                            'attribute' => 'author_name',
                            'format' => 'text',
                            'label' => 'Имя Автора',
                            'content' => function($model)
                            {
                                return (!empty($model['author_name'])) ? $model['author_name'] : 'Не указано';
                            }
                        ],
                        [
                            'attribute' => 'author_phone',
                            'format' => 'url',
                            'label' => 'Телефон автора',
                            'content' => function($model)
                            {
                                return (!empty($model['author_phone'])) ? $model['author_phone'] : 'Не указан';
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
                            'attribute' => 'status',
                            'format' => 'text',
                            'label' => 'Статус',
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
                                    if(Yii::$app->user->can('admin') or Yii::$app->user->can('editor'))
                                    {
                                        return true;
                                    }
                                },
                                'delete' => function ($model) {
                                    if(Yii::$app->user->can('admin') or Yii::$app->user->can('editor'))
                                    {
                                        return true;
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

                                                url = 'order/remove';

                                                grid_id = '#orders-grid';

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
