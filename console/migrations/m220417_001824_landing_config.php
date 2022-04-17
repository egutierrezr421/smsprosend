<?php

use yii\db\Migration;

/**
 * Class m220417_001824_landing_config
 */
class m220417_001824_landing_config extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%landing}}',
            [
                'id' => $this->primaryKey(),

                'welcome_text' => $this->text(),

                'about_short_text' => $this->text(),
                'about_text' => $this->text(),

                'app_short_text' => $this->text(),
                'app_text' => $this->text(),
                'app_link' => $this->string(),

                'facebook_url' => $this->string(),
                'instagram_url' => $this->string(),
                'linkedin_url' => $this->string(),
                'twitter_url' => $this->string(),

                'privacy_text' => $this->text(),

                'service_recharge_mobile_text' => $this->text(),
                'service_recharge_nauta_text' => $this->text(),
                'service_call_text' => $this->text(),
                'service_sms_text' => $this->text(),
                'service_videocall_text' => $this->text(),
                'service_videocall3d_text' => $this->text(),
                'service_2fa_text' => $this->text(),

                'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%landing}}');
    }
}
