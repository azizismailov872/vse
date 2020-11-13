<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['reset-password','token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Здравствуйте <?= Html::encode($user->email) ?>,</p>

    <p>Перейдите по ссылке чтобы изменть пароль</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
