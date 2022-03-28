<?php

use yii\db\Migration;

/**
 * Class m220325_192959_sms
 */
class m220325_192959_sms extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%sms}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'customer_id' => $this->integer(),
                'receptor_country_id' => $this->integer(),
                'receptor_phone_number' => $this->string(),
                'message' => $this->text(),
                'cost' => $this->decimal(5,2),
                'encrypt_type' => $this->integer(),
                'id_msg' => $this->string(),
                'response_qvatel' => $this->text(),
                'status' => $this->tinyInteger(1)->notNull()->defaultValue('1'),
                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );

        $this->createIndex('fk_sms_user1_idx', '{{%sms}}', ['user_id']);

        $this->addForeignKey(
            'fk_sms_user1',
            '{{%sms}}',
            ['user_id'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('fk_sms_customer1_idx', '{{%sms}}', ['customer_id']);

        $this->addForeignKey(
            'fk_sms_customer1',
            '{{%sms}}',
            ['customer_id'],
            '{{%customer}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('fk_sms_country1_idx', '{{%sms}}', ['receptor_country_id']);

        $this->addForeignKey(
            'fk_sms_country1',
            '{{%sms}}',
            ['receptor_country_id'],
            '{{%country}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%sms}}');
    }
}
