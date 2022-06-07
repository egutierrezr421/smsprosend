<?php

use yii\db\Migration;

/**
 * Class m220604_143648_add_fields_to_table_sms
 */
class m220604_143648_add_fields_to_table_sms extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sms','count_consumed', $this->integer()->defaultValue(1));
        $this->addColumn('sms','res_multisms', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sms','count_consumed');
        $this->dropColumn('sms','res_multisms');
    }
}
