<?php

namespace backend\models;

use Yii;

class UtilsConstants
{
    const SMS_TYPE_NORMAL = 1;
    const SMS_TYPE_PROGRAMED = 2;

    const SMS_STATUS_SENDED = 1;
    const SMS_STATUS_PENDING = 2;
    const SMS_STATUS_SUCCESS = 3;
    const SMS_STATUS_FAIL = 4;
    const SMS_STATUS_PROGRAMED = 5;

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

    const PREFIX_TOKEN_APP = 'APP-';
    const PREFIX_TOKEN_CUSTOMER = 'CUS-';

    const UPDATE_NUMBER_PLUS = 1;
    const UPDATE_NUMBER_MINUS = 2;
    const UPDATE_NUMBER_SET = 3;

    const SERVICES_CODE_SMS = '01';
    const SERVICES_CODE_RECHARGE_MOBILE = '02';
    const SERVICES_CODE_RECHARGE_NAUTA = '03';
    const SERVICES_CODE_CALL = '04';
    const SERVICES_CODE_VIDEOCALL = '05';
    const SERVICES_CODE_VIDEOCALL_3D = '06';
    const SERVICES_CODE_2FA = '07';

    const NEWS_TYPE_OFFERS = 1;
    const NEWS_TYPE_NEWS = 2;

    const RECHARGE_TYPE_MOBILE = 1;
    const RECHARGE_TYPE_NAUTA = 2;

    const RECHARGE_ETECSA_STATUS_PENDING = 1;
    const RECHARGE_ETECSA_STATUS_COMPLETE = 2;

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

    /**
     * Servicios code
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getServicesCodeName($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::SERVICES_CODE_SMS] = Yii::t('backend', 'Mensajes');
        $array[self::SERVICES_CODE_RECHARGE_MOBILE] = Yii::t('backend', 'Recarga móvil');
        $array[self::SERVICES_CODE_RECHARGE_NAUTA] = Yii::t('backend', 'Recarga nauta');
        $array[self::SERVICES_CODE_CALL] = Yii::t('backend', 'Llamadas');
        $array[self::SERVICES_CODE_VIDEOCALL] = Yii::t('backend', 'Videollamadas');
        $array[self::SERVICES_CODE_VIDEOCALL_3D] = Yii::t('backend', 'Videollamadas 3D');
        $array[self::SERVICES_CODE_2FA] = Yii::t('backend', '2FA');

        return self::getValueOfArray($array,$value,$optional_value);
    }

    /**
     * Tipos de sms
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getSmsType($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::SMS_TYPE_NORMAL] = Yii::t('backend', 'Normal');
        $array[self::SMS_TYPE_PROGRAMED] = Yii::t('backend', 'Programado');


        return self::getValueOfArray($array,$value,$optional_value);
    }

    /**
     * Tipos de news
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getNewsType($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::NEWS_TYPE_OFFERS] = Yii::t('backend', 'Ofertas');
        $array[self::NEWS_TYPE_NEWS] = Yii::t('backend', 'Novedades');


        return self::getValueOfArray($array,$value,$optional_value);
    }

    /**
     * Tipos de recarga
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getRechargeType($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::RECHARGE_TYPE_MOBILE] = Yii::t('backend', 'Recarga programada');
        $array[self::RECHARGE_TYPE_NAUTA] = Yii::t('backend', 'Recarga programada nauta');


        return self::getValueOfArray($array,$value,$optional_value);
    }

    /**
     * Estado de recarga de etecsa
     *
     * @param null|integer $value
     * @param boolean $optional_value Poner este valor en true cuando se quiere mostrar en los index el valor específico pero este es opcional, evita dar error y devuelve null
     * @return array|mixed
     */
    public static function getStatusRechargeEtecsa($value = null, $optional_value = false)
    {
        $array = [];

        $array[self::RECHARGE_ETECSA_STATUS_PENDING] = Yii::t('backend', 'Pendiente');
        $array[self::RECHARGE_ETECSA_STATUS_COMPLETE] = Yii::t('backend', 'Completada');


        return self::getValueOfArray($array,$value,$optional_value);
    }
}