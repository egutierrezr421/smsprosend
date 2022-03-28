<?php

/* @var $this yii\web\View */
/* @var $model backend\models\business\AppAccess */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Integración API');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Integración API'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-access-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
