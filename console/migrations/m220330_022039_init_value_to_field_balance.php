<?php

use yii\db\Migration;
use backend\models\business\Recharge;
use backend\models\UtilsConstants;
use common\models\User;

/**
 * Class m220330_022039_init_value_to_field_balance
 */
class m220330_022039_init_value_to_field_balance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $list = Yii::$app->authManager->getUserIdsByRole(User::ROLE_BASIC);

        foreach ($list AS $user_id)
        {
            $mount_approv = Recharge::getTotalAmountByStatus(UtilsConstants::RECHARGE_STATUS_APPROVED, $user_id);
            $amount_consumed = Recharge::getTotalConsumed($user_id);
            $new_balance = ($mount_approv > 0) ? $mount_approv - $amount_consumed : 0;
            User::updateBalance($user_id,UtilsConstants::UPDATE_NUMBER_SET, $new_balance);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220330_022039_init_value_to_field_balance cannot be reverted.\n";

        return true;
    }

}
