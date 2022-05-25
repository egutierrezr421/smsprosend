<?php

use yii\db\Migration;

/**
 * Class m220523_162848_create_table_recharge_etecsa
 */
class m220523_162848_create_table_recharge_etecsa extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%recharge_etecsa}}', [
            'id' => $this->primaryKey(),
            'recharge_etecsa_type_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'customer_id' => $this->integer(),
            'operator' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'total_cost' => $this->decimal(10,2)->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'status' => $this->integer()->notNull()->defaultValue('1'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createIndex('fk_recharge_etecsa_type1_idx', '{{%recharge_etecsa}}', ['recharge_etecsa_type_id']);
        $this->addForeignKey('fk_recharge_etecsa_type1', '{{%recharge_etecsa}}', 'recharge_etecsa_type_id', '{{%recharge_etecsa_type}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('fk_recharge_etecsa_user_idx', '{{%recharge_etecsa}}', ['user_id']);
        $this->addForeignKey('fk_recharge_etecsa_user1', '{{%recharge_etecsa}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('fk_customer_recharge_idx', '{{%recharge_etecsa}}', ['customer_id']);
        $this->addForeignKey('fk_customer_recharge1', '{{%recharge_etecsa}}', 'customer_id', '{{%customer}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%recharge_etecsa}}');
    }
}
