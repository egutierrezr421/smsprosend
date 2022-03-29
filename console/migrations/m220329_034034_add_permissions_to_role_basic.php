<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m220329_034034_add_permissions_to_role_basic
 */
class m220329_034034_add_permissions_to_role_basic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $role_basic = $auth->getRole(User::ROLE_BASIC);

        if($auth->getPermission('/setting/change-office-status'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/setting/change-office-status'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/setting/change-office-status');
            $create_permission_1->description = '/setting/change-office-status';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/customer/*'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/customer/*'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/customer/*');
            $create_permission_1->description = '/customer/*';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/group-customer/*'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/group-customer/*'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/group-customer/*');
            $create_permission_1->description = '/group-customer/*';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/app-access/*'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/app-access/*'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/app-access/*');
            $create_permission_1->description = '/app-access/*';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/sms/index'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/sms/index'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/sms/index');
            $create_permission_1->description = '/sms/index';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/sms/view'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/sms/view'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/sms/view');
            $create_permission_1->description = '/sms/view';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/sms/create'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/sms/create'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/sms/create');
            $create_permission_1->description = '/sms/create';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/sms/check-status'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/sms/check-status'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/sms/check-status');
            $create_permission_1->description = '/sms/check-status';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/sms-group/index'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/sms-group/index'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/sms-group/index');
            $create_permission_1->description = '/sms-group/index';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/sms-group/view'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/sms-group/view'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/sms-group/view');
            $create_permission_1->description = '/sms-group/view';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/sms-group/create'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/sms-group/create'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/sms-group/create');
            $create_permission_1->description = '/sms-group/create';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/recharge/index'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/recharge/index'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/recharge/index');
            $create_permission_1->description = '/recharge/index';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/recharge/view'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/recharge/view'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/recharge/view');
            $create_permission_1->description = '/recharge/view';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/recharge/create'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/recharge/create'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/recharge/create');
            $create_permission_1->description = '/recharge/create';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/api-doc/index'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/api-doc/index'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/api-doc/index');
            $create_permission_1->description = '/api-doc/index';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/api-doc/view'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/api-doc/view'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/api-doc/view');
            $create_permission_1->description = '/api-doc/view';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/api-doc/export'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/api-doc/export'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/api-doc/export');
            $create_permission_1->description = '/api-doc/export';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/api-doc/select_export'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/api-doc/select_export'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/api-doc/select_export');
            $create_permission_1->description = '/api-doc/select_export';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }

        if($auth->getPermission('/payment-method/get-payment'))
        {
            $auth->addChild($role_basic, $auth->getPermission('/payment-method/get-payment'));
        }
        else
        {
            $create_permission_1 = $auth->createPermission('/payment-method/get-payment');
            $create_permission_1->description = '/payment-method/get-payment';
            $auth->add($create_permission_1);
            $auth->addChild($role_basic, $create_permission_1);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $role_basic = $auth->getRole(User::ROLE_BASIC);

        $auth->removeChild($role_basic, $auth->getPermission('/setting/change-office-status'));
        $auth->removeChild($role_basic, $auth->getPermission('/customer/*'));
        $auth->removeChild($role_basic, $auth->getPermission('/group-customer/*'));
        $auth->removeChild($role_basic, $auth->getPermission('/app-access/*'));

        $auth->removeChild($role_basic, $auth->getPermission('/sms/index'));
        $auth->removeChild($role_basic, $auth->getPermission('/sms/view'));
        $auth->removeChild($role_basic, $auth->getPermission('/sms/create'));
        $auth->removeChild($role_basic, $auth->getPermission('/sms/check-status'));

        $auth->removeChild($role_basic, $auth->getPermission('/sms-group/index'));
        $auth->removeChild($role_basic, $auth->getPermission('/sms-group/view'));
        $auth->removeChild($role_basic, $auth->getPermission('/sms-group/create'));

        $auth->removeChild($role_basic, $auth->getPermission('/recharge/index'));
        $auth->removeChild($role_basic, $auth->getPermission('/recharge/view'));
        $auth->removeChild($role_basic, $auth->getPermission('/recharge/create'));

        $auth->removeChild($role_basic, $auth->getPermission('/api-doc/index'));
        $auth->removeChild($role_basic, $auth->getPermission('/api-doc/view'));
        $auth->removeChild($role_basic, $auth->getPermission('/api-doc/export'));
        $auth->removeChild($role_basic, $auth->getPermission('/api-doc/select_export'));
        $auth->removeChild($role_basic, $auth->getPermission('/payment-method/get-payment'));
    }
}
