<?php

use backend\models\business\Recharge;
use backend\models\settings\Setting;
use backend\models\UtilsConstants;
use backend\models\business\Sms;

/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Panel de control');

?>

<div class="site-index">
    <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>$<?= Recharge::getAvailableBalance() ?></h3>

                    <p><?= Yii::t('backend','Fondos disponibles') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>

                <a class="small-box-footer">
                    &nbsp;
                </a>

            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>$<?= Recharge::getTotalConsumed() ?></h3>

                    <p><?= Yii::t('backend','Fondos consumidos') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-level-down"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-custom-yellow">
                <div class="inner">
                    <h3>$<?= Recharge::getTotalAmountByStatus(UtilsConstants::RECHARGE_STATUS_PENDING) ?></h3>

                    <p><?= Yii::t('backend','Fondos pendientes de aprobación') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-edit"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red-gradient">
                <div class="inner">
                    <h3>$<?= Recharge::getTotalAmountByStatus(UtilsConstants::RECHARGE_STATUS_REJECTED) ?></h3>

                    <p><?= Yii::t('backend','Fondos rechazados') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-close"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?= Sms::getTotalSms() ?></h3>

                    <p><?= Yii::t('backend','SMS simples consumidos') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-comment"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?= Sms::getTotalSmsGroup() ?></h3>

                    <p><?= Yii::t('backend','SMS masivos consumidos') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-comments"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','SMS asignados') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-comments-o"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','SMS enviados por hijos') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-commenting"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','SMS PRO simples consumidos') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-commenting-o"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','SMS PRO masivos consumidos') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-comments-o"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','SMS encriptados consumidos') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-comments-o"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','LLamadas de voz') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-phone"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','Videollamadas') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-video-camera"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','Videollamadas grupales') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>0</h3>

                    <p><?= Yii::t('backend','Videollamadas 5d') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a class="small-box-footer">
                    &nbsp;
                </a>
            </div>
        </div>

    </div>
</div>
