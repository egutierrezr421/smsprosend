<?php

use yii\db\Migration;

class m220325_033817_create_table_customer_has_group_customer extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%customer_has_group_customer}}',
            [
                'customer_id' => $this->integer()->notNull(),
                'group_customer_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%customer_has_group_customer}}', ['customer_id', 'group_customer_id']);

        $this->createIndex('fk_customer_has_group_customer_customer1_idx', '{{%customer_has_group_customer}}', ['customer_id']);
        $this->createIndex('fk_customer_has_group_customer_group_customer1_idx', '{{%customer_has_group_customer}}', ['group_customer_id']);

        $this->addForeignKey(
            'fk_customer_has_group_customer_customer1',
            '{{%customer_has_group_customer}}',
            ['customer_id'],
            '{{%customer}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_customer_has_group_customer_group_customer1',
            '{{%customer_has_group_customer}}',
            ['group_customer_id'],
            '{{%group_customer}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%customer_has_group_customer}}');
    }
}
