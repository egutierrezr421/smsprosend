<?php

use yii\db\Migration;

/**
 * Class m220326_151345_recharge
 */
class m220326_151345_recharge extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%recharge}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'authorized_by' => $this->integer(),
                'payment_method_id' => $this->integer(),
                'amount' => $this->decimal(10,2),
                'commission' => $this->decimal(10,2),
                'total_to_pay' => $this->decimal(10,2),
                'source_account' => $this->string(),
                'target_account' => $this->string(),
                'paid' => $this->tinyInteger(1)->notNull()->defaultValue('0'),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'rejected_note' => $this->text(),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );

        $this->createIndex('fk_recharge_user1_idx', '{{%recharge}}', ['user_id']);

        $this->addForeignKey(
            'fk_recharge_user1',
            '{{%recharge}}',
            ['user_id'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('fk_recharge_user2_idx', '{{%recharge}}', ['authorized_by']);

        $this->addForeignKey(
            'fk_recharge_user2',
            '{{%recharge}}',
            ['authorized_by'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('fk_recharge_payment_method1_idx', '{{%recharge}}', ['payment_method_id']);

        $this->addForeignKey(
            'fk_recharge_payment_method1',
            '{{%recharge}}',
            ['payment_method_id'],
            '{{%payment_method}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%recharge}}');
    }
}
