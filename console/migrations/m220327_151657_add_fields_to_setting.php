<?php

use yii\db\Migration;

/**
 * Class m220327_151657_add_fields_to_setting
 */
class m220327_151657_add_fields_to_setting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('setting','office_status', $this->tinyInteger(1)->defaultValue(1));
        $this->addColumn('setting','token_qvatel', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('setting','office_status');
        $this->dropColumn('setting','token_qvatel');
    }

}
