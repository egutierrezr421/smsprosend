<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\Recharge */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Recarga');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Recargas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
