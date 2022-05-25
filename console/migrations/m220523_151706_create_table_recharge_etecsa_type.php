<?php

use yii\db\Migration;

/**
 * Class m220523_151706_create_table_recharge_etecsa_type
 */
class m220523_151706_create_table_recharge_etecsa_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%recharge_etecsa_type}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'description' => $this->text(),
                'cost' => $this->decimal(10,2)->notNull(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%recharge_etecsa_type}}');
    }
}
