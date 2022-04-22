<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $is_frontend boolean */

if($is_frontend) {
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/site/reset-password', 'token' => $user->password_reset_token]);
} else {
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/security/user/reset-password', 'token' => $user->password_reset_token]);
}
?>
 <?= Yii::t('common','Estimado').' '.$user->username ?>,

<?= Yii::t('common','Siga el enlace de abajo para restablecer su contraseña').':' ?>

<?= $resetLink ?>
