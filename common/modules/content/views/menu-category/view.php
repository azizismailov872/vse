<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
?>
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
                <p>
                    <?= Html::a('Изменить',Url::toRoute(['/menu-category/update/'.$model->id]),['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить',Url::toRoute(['/menu-category/delete/'.$model->id]),[
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы точно хотите удалить эту запись ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <h2>ID</h2>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-12">
                               <h3><?= $model->id;?></h3>
                           </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                <h2>Название категории меню</h2>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-12">
                               <h3><?= $model->title;?></h3>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>