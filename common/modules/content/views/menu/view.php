<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\modules\content\models\Menu;
?>
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
                    <?= Html::a('Изменить',Url::toRoute(['/menu/update/'.$model->id]), ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить',Url::toRoute(['/menu/delete/'.$model->id]), [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы точно хотите удалить ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'title',
                            'format' => 'text',
                            'label' => 'Название',
                        ],
                        [
                            'attribute' => 'parent_id',
                            'format' => 'url',
                            'label' => 'Родительское меню',
                            'value' => function($model)
                            {
                                return ($model->parent_id !== 0) ? Menu::getParentMenuName($model->parent_id) : 'Нет родителя';
                            }
                        ],
                        [
                            'attribute' => 'category_id',
                            'format' => 'text',
                            'label' => 'Категория',
                            'value' => function($model){
                                return ($model->category_id !== 0) ? $model->category->title : 'Нет категории';
                            }
                          
                        ],
                        [
                            'attribute' => 'url',
                            'format' => 'text',
                            'label' => 'Ссылка',
                            'value' => $model->url,
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'text',
                            'label' => 'Статус',
                            'value' => function($model)
                            {
                                return ($model->status !== 0) ? 'Активен' : 'Не активен';
                            }
                        ],
                        [
                            'attribute' => 'icon',
                            'format' => 'html',
                            'label' => 'Иконка',
                            'value' => function($model)
                            {
                                return (!empty($model->icon)) ? '<span class="'.$model->icon.'"></span>' : 'Нет иконки';
                            }
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>