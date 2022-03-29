<?php

use yii\db\Migration;
use backend\models\business\Customer;
use backend\models\business\AppAccess;

/**
 * Class m220329_195803_update_system_tokens
 */
class m220329_195803_update_system_tokens extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $customers = Customer::find()->all();
        foreach ($customers AS $key => $customer) {
            $customer->token = Customer::generateToken();
            $customer->save(false);
        }

        $apps = AppAccess::find()->all();
        foreach ($apps AS $key => $app) {
            $app->token = AppAccess::generateToken();
            $app->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220329_195803_update_system_tokens cannot be reverted.\n";

        return true;

    }


}
