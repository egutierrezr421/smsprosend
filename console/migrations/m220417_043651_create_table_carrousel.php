<?php

use yii\db\Migration;

/**
 * Class m220417_043651_create_table_carrousel
 */
class m220417_043651_create_table_carrousel extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%carrousel}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'image' => $this->string()->notNull(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%carrousel}}');
    }
}
