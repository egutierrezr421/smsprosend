<?php

use mdm\admin\components\Helper;
//use dmstr\widgets\Menu;
use backend\models\settings\Setting;
use common\models\User;
use backend\widgets\CustomMenu;
use backend\models\settings\Landing;

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="office-panel">
            Estado de oficina <?= Setting::getOfficeStatusWithTags() ?>
        </div>

        <?php

        $menu_items = [
            //Inicio
            [
                'label' => Yii::t("backend","Inicio"),
                'icon' => 'dashboard ',
                'url' => ['/site/index'],
            ],

            //clientes
            [
                'label' => Yii::t("backend","Clientes"),
                'icon' => 'users',
                'url' => '#',
                'items' => [
                    [
                        'label' => Yii::t("backend","Todos tus clientes"),
                        'icon' => 'circle-o',
                        'url' => ['/customer/index'],
                    ],

                    [
                        'label' => Yii::t("backend","Grupos de clientes"),
                        'icon' => 'circle-o',
                        'url' => ['/group-customer/index'],
                    ],

                    [
                        'label' => Yii::t("backend","Negocios asociados"),
                        'icon' => 'circle-o',
                        'url' => [''],
                    ],
                ],
            ],

            //Mensajes
            [
                'label' => Yii::t("backend","Nuevo"),
                'icon' => 'commenting',
                'url' => '#',
                'items' => [
                    [
                        'label' => Yii::t("backend","Enviar SMS simple"),
                        'icon' => 'circle-o',
                        'url' => ['/sms/create'],
                    ],

                    [
                        'label' => Yii::t("backend","Enviar SMS grupal"),
                        'icon' => 'circle-o',
                        'url' => ['/sms-group/create'],
                    ],

                    [
                        'label' => Yii::t("backend","Enviar SMS encriptado"),
                        'icon' => 'circle-o',
                        'url' => [''],
                    ],

                    [
                        'label' => Yii::t("backend","Enviar SMS PRO simple"),
                        'icon' => 'circle-o',
                        'url' => [''],
                    ],

                    [
                        'label' => Yii::t("backend","Enviar SMS PRO grupal"),
                        'icon' => 'circle-o',
                        'url' => [''],
                    ],

                    [
                        'label' => Yii::t("backend","SMS enviados"),
                        'icon' => 'circle-o',
                        'url' => ['/sms/index'],
                    ],

                    [
                        'label' => Yii::t("backend","SMS grupales enviados"),
                        'icon' => 'circle-o',
                        'url' => ['/sms-group/index'],
                    ],
                ],
            ],

            [
                'label' => Yii::t("backend","Recargar"),
                'icon' => 'magic',
                'url' => ['/recharge/index'],
            ],

            [
                'label' => Yii::t("backend","Recargas ETECSA"),
                'icon' => 'refresh',
                'url' => ['/recharge-etecsa/index'],
            ],

            [
                'label' => Yii::t("backend","Integración API"),
                'icon' => 'code',
                'url' => ['/app-access/index'],
            ],

            [
                'label' => Yii::t("backend", "Documentación API"),
                'icon' => 'book',
                'url' => ['/api-doc/index'],
            ],


            //Administracion
            [
                'label' => Yii::t("backend","Administración"),
                'icon' => 'cogs',
                'url' => '#',
                'items' => [
                    [
                        'label' => Yii::t("backend","Usuarios"),
                        'icon' => 'users',
                        'url' => ['/security/user'],
                    ],

                    [
                        'label' => Yii::t("backend", "Países"),
                        'icon' => 'globe',
                        'url' => ['/country/index'],
                    ],

                    [
                        'label' => Yii::t("backend", "Métodos de pago"),
                        'icon' => 'credit-card',
                        'url' => ['/payment-method/index'],
                    ],

                    [
                        'label' => Yii::t("backend", "Ajustes de frontend"),
                        'icon' => 'cog',
                        'url' => ['/landing/update', 'id' => Landing::getIdLanding()],
                    ],

                    [
                        'label' => Yii::t("backend", "Imágenes de carrusel"),
                        'icon' => 'image',
                        'url' => ['/carrousel/index'],
                    ],

                    [
                        'label' => Yii::t("backend", "Ajustes de sistema"),
                        'icon' => 'cog',
                        'url' => ['/setting/update', 'id' => Setting::getIdSettingByActiveLanguage()],
                    ],

                    [
                        'label' => Yii::t("backend", "Noticias"),
                        'icon' => 'list',
                        'url' => ['/news/index'],
                    ],

                    [
                        'label' => Yii::t("backend", "Ofertas de recargas"),
                        'icon' => 'tasks',
                        'url' => ['/recharge-etecsa-type/index'],
                    ],
                ],
            ],

            //Desarrolladores
            [
                'label' => Yii::t("backend", "DESARROLLADORES"),
                'icon' => 'warning',
                'url' => '#',
                'items' => [

                    //Seguridad
                    [
                        'label' => Yii::t("backend", "Seguridad"),
                        'icon' => 'shield',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => Yii::t("backend", "Rutas"),
                                'icon' => 'circle',
                                'url' => ['/security/route/index/'],
                            ],

                            [
                                'label' => Yii::t("backend", "Permisos"),
                                'icon' => 'circle',
                                'url' => ['/security/permission'],
                            ],
                            [
                                'label' => Yii::t("backend", "Roles"),
                                'icon' => 'circle',
                                'url' => ['/security/role'],
                            ],
                        ],
                    ],

                    //Support
                    [
                        'label' => Yii::t("backend", "Soporte"),
                        'icon' => 'cog',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Grupos de FAQ'),
                                'icon' => 'list',
                                'url' => ['/faq-group/index'],
                            ],

                            [
                                'label' => Yii::t('backend', 'FAQ'),
                                'icon' => 'question',
                                'url' => ['/faq/index'],
                            ],

                            [
                                'label' => Yii::t("backend", "Tareas de CronJob"),
                                'icon' => 'clock-o',
                                'url' => ['/cronjob-task/index'],
                            ],
                            [
                                'label' => Yii::t("backend", "Trazas de CronJob"),
                                'icon' => 'line-chart',
                                'url' => ['/cronjob-log/index'],
                            ],
                            [
                                'label' => Yii::t("backend", "Trazas API"),
                                'icon' => 'line-chart',
                                'url' => ['/api-request-log/index'],
                            ],
                        ],
                    ],

                    [
                        'label' => Yii::t('backend', 'Envío de correo'),
                        'icon' => 'envelope',
                        'url' => ['/config-mailer/update', 'id' => 1],
                    ],

                    [
                        'label' => Yii::t("backend", "Idiomas"),
                        'icon' => 'flag',
                        'url' => ['/language/index'],
                    ],

                    [
                        'label' => Yii::t("backend", "Traducciones"),
                        'icon' => 'language',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t("backend", "Listado"), 'icon' => 'list', 'url' => ['/source-message/index'],],
                            ['label' => Yii::t("backend", "Importar"), 'icon' => 'upload', 'url' => ['/source-message/import'],],

                        ],
                    ],

                    ['label' => 'Phpinfo', 'icon' => 'info-circle', 'url' => ['/site/phpinfo'], 'target'=>'_blank', 'visible' => Yii::$app->user->can(User::ROLE_SUPERADMIN)],

                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii/default'], 'target'=>'_blank', 'visible' => Yii::$app->user->can(User::ROLE_SUPERADMIN) && YII_ENV_DEV],

                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'], 'target'=>'_blank', 'visible' => Yii::$app->user->can(User::ROLE_SUPERADMIN) && YII_ENV_DEV],
                ],
                'visible' => Yii::$app->user->can(User::ROLE_SUPERADMIN)
            ],
        ];

        $menu_items = Helper::filter($menu_items);

        ?>

        <?= CustomMenu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menu_items
            ]
        ) ?>

    </section>

</aside>
