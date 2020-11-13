<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>
<div class="row">
	<div class="col-12">
		<div class="x_panel">
			<div class="row">
				<div class="col-12 justify-content-center d-flex">
                    <img src="<?= $model->getImage();?>" class="category-photo" alt="">
                </div>
			</div>
			<div class="x_title">
				<h2><?= Html::encode($this->title);?></h2>
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
			        <?= Html::a('Изменить',Url::toRoute(['/category/update/'.$model->id]), ['class' => 'btn btn-success']) ?>
			        <?= Html::a('Удалить',Url::toRoute(['/category/delete/'.$model->id]), [
			            'class' => 'btn btn-danger',
			            'data' => [
			                'confirm' => 'Are you sure you want to delete this item?',
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
							'format' => 'html',
							'label' => 'Название',
							'value' => function($model)
							{
								return '<h3>'.$model->title.'</h3>';
							}
			            ],
						[
							'attribute' => 'url',
							'format' => 'url',
							'label' => 'Ссылка',
						],
						[
							'attribute' => 'order',
							'format' => 'text',
							'label' => 'Очередность',
						],
						[
							'attribute' => 'status',
							'format' => 'text',
							'label' => 'Статус',
							'value' => function($model)
							{
								return ($model->status == 1) ? 'Активен' : 'Не активен';
							}
						],
						[
							'attribute' => 'icon',
							'format' => 'html',
							'label' => 'Иконка',
							'value' => function($model)
							{
								return (!empty($model->icon)) ? '<span class="'.$model->icon.'"></span>' : 'Нет иконки' ;
							}
						],
						[
	                        'attribute'=>'created_at',
	                        'format'=>['date','php: yy-m-d H:i:s'],//raw, html
	                        'label' => 'Дата создания',
	                    ],
	                    [
	                        'attribute'=>'updated_at',
	                        'format'=>['date','php: yy-m-d H:i:s'],//raw, html
	                        'label' => 'Дата обновления',
	                    ],
			        ],
			    ]) ?>
			</div>
		</div>
	</div>
</div>