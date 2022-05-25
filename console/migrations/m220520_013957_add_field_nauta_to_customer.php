<?php

use yii\db\Migration;

/**
 * Class m220520_013957_add_field_nauta_to_customer
 */
class m220520_013957_add_field_nauta_to_customer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer','nauta', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer','nauta');
    }

}
