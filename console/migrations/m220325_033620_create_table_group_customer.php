<?php

use yii\db\Migration;

class m220325_033620_create_table_group_customer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%group_customer}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'name' => $this->string(),
                'code' => $this->string(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );

        $this->createIndex('fk_group_customer_user1_idx', '{{%group_customer}}', ['user_id']);

        $this->addForeignKey(
            'fk_group_customer_user1',
            '{{%group_customer}}',
            ['user_id'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%group_customer}}');
    }
}
