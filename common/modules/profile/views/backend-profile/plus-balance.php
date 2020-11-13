<?php 

use yii\helpres\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">
	<div class="col-12">
		<div class="x_panel">
			<?php if($model->hasErrors()):?>
                <?php foreach ($model->getErrors() as $key => $value):?>
                    <div class="alert alert-danger" role="alert">
                        <?= $model->getAttributeLabel($key).': '.$value[0];?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
			<div class="x_title">
				<h2>Пополнить баланс</h2>
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
                    'options' => [
                        'id' => 'plus-balance',
                        'class' => 'form-horizontal form-label-left',
                    ],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ]
                    ]
                ]);?>
                <div class="row justify-content-center align-items-center">
                <?= $form->field($model,'email',[
                    'template' => '
                        <div class="col-12 d-flex justify-content-center">
                            {label}
                        </div>
                        <div class="col-6">
                            {input}
                        </div>
                    '
                ])->textInput(['class' => 'form-control','placeholder' => 'user@example'])->label('Почта пользователя');?>
                </div>
                <div class="row justify-content-center align-items-center">
                    <?= $form->field($model,'balance',[
                    'template' => '
                        <div class="col-12 d-flex justify-content-center">
                            {label}
                        </div>
                        <div class="col-6">
                            {input}
                        </div>
                    '
                ])->textInput(['class' => 'form-control','placeholder' => '0','value' => 0,'type' => 'number'])->label('Сумма пополнения');?>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-auto mt-2">
                        <?= Html::submitButton('Пополнить', ['class' => 'btn btn-success']); ?>
                    </div>
                </div>
                <?php ActiveForm::end();?>
			</div>
		</div>	
	</div>
</div>