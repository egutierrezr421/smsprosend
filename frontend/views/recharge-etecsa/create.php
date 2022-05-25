<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\RechargeEtecsa */

$this->title = Yii::t('backend', 'Nueva').' '. Yii::t('backend', 'Recarga');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recharge-etecsa-create">

    <div class="container">
        <div class="center-box w-65">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
