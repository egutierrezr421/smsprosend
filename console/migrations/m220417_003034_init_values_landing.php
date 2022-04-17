<?php

use yii\db\Migration;
use backend\models\settings\Landing;

/**
 * Class m220417_003034_init_values_landing
 */
class m220417_003034_init_values_landing extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad amet deleniti iure officia repellendus rerum. Id modi numquam saepe? Asperiores corporis esse exercitationem quae quasi quo quod reiciendis repudiandae totam.';

        $model = new Landing([
            'welcome_text' => $lorem,

            'about_short_text' => $lorem,
            'about_text' => $lorem,

            'app_short_text' => $lorem,
            'app_text' => $lorem,
            'app_link' => 'https://miapp.com/app.apk',

            'facebook_url' => 'https://facebook.com/kubacel',
            'instagram_url' => 'https://instagram.com/kubacel',
            'linkedin_url' => 'https://linkedin.com/kubacel',
            'twitter_url' => 'https://twitter.com/kubacel',

            'privacy_text' => $lorem,

            'service_recharge_mobile_text' => $lorem,
            'service_recharge_nauta_text' => $lorem,
            'service_call_text' => $lorem,
            'service_sms_text' => $lorem,
            'service_videocall_text' => $lorem,
            'service_videocall3d_text' => $lorem,
            'service_2fa_text' => $lorem,
        ]);

        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Landing::deleteAll();
    }

}
