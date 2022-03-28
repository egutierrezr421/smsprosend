<?php

use yii\db\Migration;

/**
 * Class m220327_152246_add_fields_to_customer
 */
class m220327_152246_add_fields_to_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer','allow_send_sms', $this->tinyInteger(1)->defaultValue(0));
        $this->addColumn('customer','send_sms_type', $this->integer());
        $this->addColumn('customer','max_sms', $this->integer());
        $this->addColumn('customer','token', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer','allow_send_sms');
        $this->dropColumn('customer','send_sms_type');
        $this->dropColumn('customer','max_sms');
        $this->dropColumn('customer','token');
    }
}
