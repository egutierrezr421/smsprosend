<?php

/* @var $this yii\web\View */
/* @var $model backend\models\settings\Carrousel */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'Carrousel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Carrousels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrousel-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
