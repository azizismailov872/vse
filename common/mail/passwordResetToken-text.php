<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/auth/reset-password', 'token' => $user->password_reset_token]);
?>
Здравствуйте <?= $user->email ?>,

Перейдите по ссылке чтобы изменть пароль

<?= $resetLink ?>
