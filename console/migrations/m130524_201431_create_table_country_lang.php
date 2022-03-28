<?php

use yii\db\Migration;

class m130524_201431_create_table_country_lang extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%country_lang}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'language' => $this->string(2)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_country1', '{{%country_lang}}', 'country_id', '{{%country}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%country_lang}}');
    }
}
