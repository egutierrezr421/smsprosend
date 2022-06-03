<?php
use yii\helpers\Html;
use frontend\components\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $form frontend\components\bootstrap4\ActiveForm */
/* @var $model \common\models\ChangePassword*/

$this->title = Yii::t('backend', 'Cambiar Contraseña');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Perfil'), 'url' => ['/security/user/profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="center-box w-65">
        <div class="row">

        <?php $form = ActiveForm::begin(['id' => 'form-change']); ?>

            <div class="col-md-8 col-12 mb-3">
                <?= $form->field($model, 'oldPassword')->passwordInput() ?>
            </div>
            <div class="col-md-8 col-12 mb-3">
                <?= $form->field($model, 'newPassword')->passwordInput() ?>
            </div>
            <div class="col-md-8 col-12 mb-3">
                <?= $form->field($model, 'retypePassword')->passwordInput() ?>
            </div>
            <div class="col-md-8 col-12 mb-3">
                <?= Html::submitButton('<i class="fa fa-pencil"></i> '.Yii::t('backend', 'Cambiar'), ['class' => 'btn btn-primary btn-flat me-3', 'name' => 'change-button']) ?>
                <?= Html::a('<i class="fa fa-remove"></i> '.Yii::t('backend','Cancelar'),['profile'], ['class' => 'btn btn-secondary btn-flat margin', 'title' => Yii::t('backend','Cancelar')]) ?>

            </div>

        <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
