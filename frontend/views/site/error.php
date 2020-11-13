<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
if($exception->statusCode == 404) 
{
    $this->title = '404';
    $message = 'Страница не найдена';
}
$this->title = $name;
?>
<div class="error">
    <h1 class="error-header"><?= Html::encode($message);?></h1>
</div>
