<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\Recharge */

$this->title = Yii::t('backend', 'Fondear');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Recargas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="center-box">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>