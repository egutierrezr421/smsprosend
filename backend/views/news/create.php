<?php

/* @var $this yii\web\View */
/* @var $model backend\models\nomenclators\News */

$this->title = Yii::t('backend', 'Crear').' '. Yii::t('backend', 'News');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
