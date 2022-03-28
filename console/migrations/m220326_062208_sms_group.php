<?php

use yii\db\Migration;

/**
 * Class m220326_062208_sms_group
 */
class m220326_062208_sms_group extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%sms_group}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'customer_id' => $this->integer(),
                'message' => $this->text(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );

        $this->createIndex('fk_sms_group_user1_idx', '{{%sms_group}}', ['user_id']);

        $this->addForeignKey(
            'fk_sms_group_user1',
            '{{%sms_group}}',
            ['user_id'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('fk_sms_group_customer1_idx', '{{%sms_group}}', ['customer_id']);

        $this->addForeignKey(
            'fk_sms_group_customer1',
            '{{%sms_group}}',
            ['customer_id'],
            '{{%customer}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%sms_group}}');
    }
}
