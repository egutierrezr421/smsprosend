<?php

namespace backend\models;

use Yii;

class UtilsConstants
{

    const SMS_STATUS_SENDED = 1;
    const SMS_STATUS_PENDING = 2;
    const SMS_STATUS_SUCCESS = 3;
    const SMS_STATUS_FAIL = 4;

    const SEND_MAIL_RESPONSE_TYPE_SUCCESS = 1;
    const SEND_MAIL_RESPONSE_TYPE_ERROR = 2;
    const SEND_MAIL_RESPONSE_TYPE_EXCEPTION = 3;
    const SEND_MAIL_RESPONSE_TYPE_CUSTOM = 4;

    const RECHARGE_STATUS_PENDING = 1;
    const RECHARGE_STATUS_APPROVED = 2;
    const RECHARGE_STATUS_REJECTED = 3;

    const API_TOKEN_QVATEL = 'e5deb6d4a749a9f70697a9ba';

    const TYPE_ACCESS_API_CUSTOMER_BALANCE = 1;
    const TYPE_ACCESS_API_CUSTOMER_LIMIT_SMS = 2;

    /**
     * @param $array
     * @param $value
     * @param $optional_value
     * @return null|string
     */
    public static function getValueOfArray($array, $value, $optional_value)
    {
        if ($value !== null) {
            return (isset($array[$value]) && !empty($array[$value]))? $array[$value] : null;
        } else {
            if($optional_value)
                return null;
            else
                return $array;
        }
    }

    /**
     * Estados de sms
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getSmsStatuses($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::SMS_STATUS_SENDED] = Yii::t('backend', 'Enviado');
        $array[self::SMS_STATUS_PENDING] = Yii::t('backend', 'Pendiente');
        $array[self::SMS_STATUS_SUCCESS] = Yii::t('backend', 'Entregado');
        $array[self::SMS_STATUS_FAIL] = Yii::t('backend', 'Fallido');

        return self::getValueOfArray($array,$value,$optional_value);
    }

    /**
     * Estados de recargas
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getRechargeStatuses($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::RECHARGE_STATUS_PENDING] = Yii::t('backend', 'Pendiente');
        $array[self::RECHARGE_STATUS_APPROVED] = Yii::t('backend', 'Aprobado');
        $array[self::RECHARGE_STATUS_REJECTED] = Yii::t('backend', 'Rechazado');

        return self::getValueOfArray($array,$value,$optional_value);
    }

    /**
     * Tipos de acceso a API por clientes
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getCustomerSmsAccessType($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::TYPE_ACCESS_API_CUSTOMER_BALANCE] = Yii::t('backend', 'Descuento de balance');
        $array[self::TYPE_ACCESS_API_CUSTOMER_LIMIT_SMS] = Yii::t('backend', 'Mensajes limitados');


        return self::getValueOfArray($array,$value,$optional_value);
    }
}