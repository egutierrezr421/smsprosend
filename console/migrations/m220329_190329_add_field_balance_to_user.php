<?php

use yii\db\Migration;

/**
 * Class m220329_190329_add_field_balance_to_user
 */
class m220329_190329_add_field_balance_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','balance', $this->decimal(15,2));
        $this->addColumn('user','url_to_notify_delivery', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user','balance');
        $this->dropColumn('user','url_to_notify_delivery');

    }

}
