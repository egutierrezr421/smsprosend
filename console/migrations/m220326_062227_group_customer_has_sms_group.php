<?php

use yii\db\Migration;

/**
 * Class m220326_062227_group_customer_has_sms_group
 */
class m220326_062227_group_customer_has_sms_group extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%group_customer_has_sms_group}}',
            [
                'group_customer_id' => $this->integer()->notNull(),
                'sms_group_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%group_customer_has_sms_group}}', ['group_customer_id', 'sms_group_id']);

        $this->createIndex('fk_group_customer_has_sms_group_group_customer1_idx', '{{%group_customer_has_sms_group}}', ['group_customer_id']);
        $this->createIndex('fk_group_customer_has_sms_group_sms_group1_idx', '{{%group_customer_has_sms_group}}', ['sms_group_id']);

        $this->addForeignKey(
            'fk_group_customer_has_sms_group_group_customer1',
            '{{%group_customer_has_sms_group}}',
            ['group_customer_id'],
            '{{%group_customer}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_group_customer_has_sms_group_sms_group1',
            '{{%group_customer_has_sms_group}}',
            ['sms_group_id'],
            '{{%sms_group}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%group_customer_has_sms_group}}');
    }
}
