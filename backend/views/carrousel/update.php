<?php

/* @var $this yii\web\View */
/* @var $model backend\models\settings\Carrousel */

$this->title = Yii::t('backend', 'Actualizar').' '. Yii::t('backend', 'Carrousel').': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Carrousels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Actualizar');
?>
<div class="carrousel-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
