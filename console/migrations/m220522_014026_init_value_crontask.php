<?php

use yii\db\Migration;
use backend\models\support\CronjobTask;

/**
 * Class m220522_014026_init_value_crontask
 */
class m220522_014026_init_value_crontask extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new CronjobTask(['name' => CronjobTask::SMSCHECK, 'status' => 1]);
        if(!$model->save()) {
            print_r($model->getErrors());
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        CronjobTask::deleteAll(['name' => CronjobTask::SMSCHECK]);
    }

}
