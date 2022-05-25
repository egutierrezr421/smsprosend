<?php

use yii\db\Migration;

/**
 * Class m220522_181822_create_table_news
 */
class m220522_181822_create_table_news extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%news}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'image' => $this->string(),
                'description' => $this->text(),
                'type' => $this->integer()->notNull(),
                'link' => $this->string(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%news}}');
    }
}
