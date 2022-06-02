<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
?>

<nav id="sidebarMenu" class="mt-2 mb-2 col-md-3 col-lg-2 d-md-block bg-blue-kubacel sidebar collapse rounded-3 sidebar-kubacel">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <?= Html::a('Inicio',['/site/client-area'],['class' => 'nav-link ']) ?>
            </li>
            <li class="nav-item">
                <?php $statistic_active = ($action_id == 'client-statistic')? 'active' : '';  ?>
                <?= Html::a('Estadísticas',['/site/client-statistic'],['class' => 'nav-link '.$statistic_active]) ?>
            </li>
            <li class="nav-item">
                <?php $offers_active = ($controller_id == 'recharge')? 'active' : '';  ?>
                <?= Html::a('Fondear mi cuenta',['/recharge/index'],['class' => 'nav-link '.$offers_active]) ?>
            </li>
            <li class="nav-item">
                <?php $offers_active = ($controller_id == 'news')? 'active' : '';  ?>
                <?= Html::a('Ofertas disponibles',['/news/offers'],['class' => 'nav-link '.$offers_active]) ?>
            </li>

            <li class="nav-item">
                <a class="collapsed nav-link " data-bs-toggle="collapse" data-bs-target="#contacts-collapse">
                    Contactos <i class="fas fa-chevron-down"></i>
                </a>
                <?php
                $open_contact = ($controller_id == 'customer' || $controller_id == 'group-customer')? 'show' : '';
                ?>
                <div class="collapse <?= $open_contact ?>" id="contacts-collapse">
                    <ul class="btn-toggle-nav ps-3 pb-1 list-unstyled">
                        <li class="nav-item">
                            <?php $customer_active = ($controller_id == 'customer')? 'active' : '';  ?>
                            <?= Html::a('Mis contactos',['/customer/index'],['class' => 'nav-link '.$customer_active]) ?>
                        </li>

                        <li class="nav-item">
                            <?php $group_customer = ($controller_id == 'group-customer')? 'active' : '';  ?>
                            <?= Html::a('Mis grupos',['/group-customer/index'],['class' => 'nav-link '.$group_customer]) ?>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="collapsed nav-link " data-bs-toggle="collapse" data-bs-target="#sms-collapse">
                    Mensajes <i class="fas fa-chevron-down"></i>
                </a>
                <?php
                $open_sms = ($controller_id == 'sms' || $controller_id == 'sms-group')? 'show' : '';
                ?>
                <div class="collapse <?= $open_sms ?>" id="sms-collapse">
                    <ul class="btn-toggle-nav ps-3 pb-1 list-unstyled">
                        <li class="nav-item">
                            <?php $sms_active = ($action_id == 'send-sms')? 'active' : '';  ?>
                            <?= Html::a('Nuevo mensaje',['/sms/send-sms'],['class' => 'nav-link '.$sms_active]) ?>
                        </li>

                        <li class="nav-item">
                            <?php $sms_group_active = ($controller_id == 'sms-group')? 'active' : '';  ?>
                            <?= Html::a('Mensajes publicitarios',['/sms-group/index'],['class' => 'nav-link '.$sms_group_active]) ?>
                        </li>

                        <li class="nav-item">
                            <?php $sms_active = ($action_id == 'history-sms-programed')? 'active' : '';  ?>
                            <?= Html::a('Mensajes programados',['/sms/history-sms-programed'],['class' => 'nav-link '.$sms_active]) ?>
                        </li>

                        <li class="nav-item">
                            <?php $history = ($action_id == 'history-sms')? 'active' : '';  ?>
                            <?= Html::a('Historial de envíos',['/sms/history-sms'],['class' => 'nav-link '.$history]) ?>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="collapsed nav-link " data-bs-toggle="collapse" data-bs-target="#recharge-etecsa-collapse">
                    Recargas <i class="fas fa-chevron-down"></i>
                </a>
                <?php
                $open_contact = ($controller_id == 'recharge-etecsa')? 'show' : '';
                ?>
                <div class="collapse <?= $open_contact ?>" id="recharge-etecsa-collapse">
                    <ul class="btn-toggle-nav ps-3 pb-1 list-unstyled">
                        <li class="nav-item">
                            <?php $new_recharge = ($action_id == 'new-recharge')? 'active' : '';  ?>
                            <?= Html::a('Nueva recarga',['/recharge-etecsa/new-recharge'],['class' => 'nav-link '.$new_recharge]) ?>
                        </li>
                        <li class="nav-item">
                            <?php $recharge_program = ($action_id == 'recharges-program')? 'active' : '';  ?>
                            <?= Html::a('Recargas programadas',['/recharge-etecsa/recharges-program'],['class' => 'nav-link '.$recharge_program]) ?>
                        </li>

                        <li class="nav-item">
                            <?php $recharges_history = ($action_id == 'recharges-history')? 'active' : '';  ?>
                            <?= Html::a('Historial de recargas',['/recharge-etecsa/recharges-history'],['class' => 'nav-link '.$recharges_history]) ?>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>
</nav>