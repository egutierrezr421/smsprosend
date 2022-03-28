<?php

use yii\db\Migration;

class m220325_033609_create_table_customer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%customer}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'country_id' => $this->integer(),
                'name' => $this->string(),
                'code' => $this->string(),
                'phone_number' => $this->string(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );

        $this->createIndex('fk_customer_country1_idx', '{{%customer}}', ['country_id']);
        $this->createIndex('fk_customer_user1_idx', '{{%customer}}', ['user_id']);

        $this->addForeignKey(
            'fk_customer_country1',
            '{{%customer}}',
            ['country_id'],
            '{{%country}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_customer_user1',
            '{{%customer}}',
            ['user_id'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%customer}}');
    }
}
