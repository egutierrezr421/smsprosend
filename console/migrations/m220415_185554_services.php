<?php

use yii\db\Migration;

/**
 * Class m220415_185554_services
 */
class m220415_185554_services extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%service}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'code' => $this->string()->notNull(),
                'price_general' => $this->decimal(10,2)->notNull(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%service}}');
    }
}
