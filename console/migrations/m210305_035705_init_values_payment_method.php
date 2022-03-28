<?php

use yii\db\Migration;
use backend\models\nomenclators\PaymentMethod;

/**
 * Class m210305_035705_init_values_payment_method
 */
class m210305_035705_init_values_payment_method extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array = [
            [1, '01', 'PAYPAL', '15.00', 'pagos@valerocorp.llc', 'Confirme si ya fue a su cuenta de PAYPAL y realizó el pago, tenga en cuenta que confirmar un pago falso puede ocasionar el bloqueo de su cuenta automáticamente'],
        ];

        foreach ($array AS $index => $value)
        {
            $model = new PaymentMethod();
            $model->code = $value[1];
            $model->name = $value[2];
            $model->commission = $value[3];
            $model->target_account = $value[4];
            $model->description = $value[5];
            if(!$model->save())
            {
                print_r($model->getFirstErrors());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        PaymentMethod::deleteAll();
    }
}
