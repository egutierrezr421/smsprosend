<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\GroupCustomer */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Grupo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grupos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-customer-create">

    <div class="container">
        <div class="center-box w-65">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
