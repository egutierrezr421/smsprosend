<?php

use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Perfil');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-profile center-box w-100">

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile text-center">
                        <img class="profile-user-img img-responsive img-circle" src="<?= User::getUrlAvatarByActiveUser(true) ?>" alt="Avatar">
                        <h3 class="profile-username text-center"><?= User::getFullNameByActiveUser() ?></h3>

                        <p class="text-center mt-3">
                        <?= Html::a(Yii::t('backend','Cambiar Contraseña'),['/site/change-password'],['class'=>'btn btn-secondary margin']) ?>
                        </p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>

            <!-- /.col -->
            <div class="col-md-9">
                <?php $form = ActiveForm::begin(); ?>

                <?= $this->render('_custom_form', [
                    'model' => $model,
                    'form' => $form
                ]) ?>

                <!-- /.nav-tabs-custom -->
                <div class="box-footer mt-5">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin','Create') : Yii::t('yii', 'Update'), ['class' => 'btn btn-primary btn-flat']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->


</div>
