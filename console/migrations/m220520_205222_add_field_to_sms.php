<?php

use yii\db\Migration;

/**
 * Class m220520_205222_add_field_to_sms
 */
class m220520_205222_add_field_to_sms extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sms','type', $this->integer()->defaultValue(1));
        $this->addColumn('sms','programmer_date', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sms','type');
        $this->dropColumn('sms','programmer_date');
    }
}
