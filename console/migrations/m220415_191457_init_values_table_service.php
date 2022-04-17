<?php

use yii\db\Migration;
use backend\models\nomenclators\Service;

/**
 * Class m220415_191457_init_values_table_service
 */
class m220415_191457_init_values_table_service extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array = [
            ['Mensajes','01'],
            ['Recarga móvil','02'],
            ['Recarga nauta','03'],
            ['Llamadas','04'],
            ['Videollamadas','05'],
            ['Videollamadas 3D','06'],
            ['2FA','07'],
        ];

        foreach ($array AS $index => $service) {
            $new_service = new Service(['name' => $service[0], 'code' => $service[1], 'price_general' => 0.05, 'status' => 0]);
            if(!$new_service->save()) {
                print_r($new_service->getErrors());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Service::deleteAll();
    }

}
