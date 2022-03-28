<?php

use yii\db\Migration;

/**
 * Class m220326_205851_app_access
 */
class m220326_205851_app_access extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%app_access}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'name' => $this->string(),
                'token' => $this->string(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );

        $this->createIndex('fk_app_access_user1_idx', '{{%app_access}}', ['user_id']);

        $this->addForeignKey(
            'fk_app_access_user1',
            '{{%app_access}}',
            ['user_id'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%app_access}}');
    }
}
