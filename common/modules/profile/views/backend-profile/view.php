<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    <?= $this->title; ?>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <?php Pjax::begin(['id' => 'user->photo']);?>
                            <!-- Current avatar -->
                            <?= Html::img($model->getImage(), ['alt'=>'Avatar', 'title'=>'Change the avatar','style' => 'width:100%;height:100%;' ,'class'=>'img-responsive avatar-view']) ?>
                            <?php Pjax::end();?>
                        </div>
                    </div>
                    <h3>
                        <?= (!empty($model->username)) ? $model->username : $model->email ?>
                    </h3>
                    <ul class="list-unstyled user_data">
                        <li>
                            <i class="bx bx-mobile-alt"></i>&nbsp;
                           <!--  < ?= Yii::t('form', 'Phone').' - '.(isset($model->phone) && !empty($model->phone)) ? $model->phone : 'Нет телефона';?> -->
                           <?= (!empty($model->phone)) ? $model->phone : 'Нет телефона';?>
                        </li>
                        <li>
                            <i class="bx bx-credit-card"></i>&nbsp;
                            <?= 'Баланс - '.$model->balance.' <u>сом</u>'; ?>
                        </li>
                    </ul>
                    <?= Html::a('<i class="fa fa-edit m-right-xs" style="margin-right:5px;"></i>'.'Изменить профиль',Url::toRoute(['/user/update/'.$model->id]), ['id'=>'update-user', 'class' => 'btn btn-success']) ?>
                    <br />
                    <?= Html::button('<i class="fa fa-trash m-right-xs" style="margin-right:5px;"></i>'.'Удалить фото',['id'=>$model->id, 'class' => 'btn btn-danger delete_profile_btn']) ?>
                    <br />
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="row">
                        <div class="col-md-9 col-xs-12">
                            <h1 class="title">
                                Информация о пользователе:
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-xs-12">
                            <h2 class="title">
                                Почта
                            </h2>
                            <p>
                                <?= $model->email ?>
                            </p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-9 col-xs-12">
                            <h2 class="title">
                                Телефон
                            </h2>
                            <p>
                                <?= !empty($model->phone) ? $model->phone : 'Не указан' ?>
                            </p>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-9 col-xs-12">
                            <h2 class="title">
                                Дата регистрации
                            </h2>
                            <p>
                                <?= date('yy-m-d H:i:s',$model->created_at);?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-xs-12">
                            <h2 class="title">
                                Дополнительная информация
                            </h2>
                            <p>
                                <?= (!empty($model->description)) ? $model->description : 'Нет информации';?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>