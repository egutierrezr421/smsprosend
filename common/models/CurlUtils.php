<?php

namespace common\models;


class CurlUtils
{
    const CURLUTIL_URL_API = 'https://monypaid.global/api/';
    const CURLUTIL_USERNAME = 'prueba1';
    const CURLUTIL_PASSWORD = 'prueba1234';
    const CURLUTIL_PIN = 383;
    const CURLUTIL_CREDIT_CARD = '2726313396811112';
    const CURLUTIL_EXPIRATION = '09/21';
    const CURLUTIL_CURRENCY = 'USD';

    /**
     * @param $user
     * @param $password
     * @return mixed
     */
    public static function login($user, $password)
    {
        $endpoint = self::CURLUTIL_URL_API.'login';
        $params_post = ['username' => $user, 'password' => $password];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $post = json_encode($params_post);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    /**
     * @param $token
     * @param Credit $model
     * @return mixed
     */
    public static function deposit($token,$model)
    {
        $endpoint = self::CURLUTIL_URL_API.'acortador/comprar/'.$model->wallet_user;
        $params_post = [
            'saldo' => $model->total_amount,
            'moneda' => self::CURLUTIL_CURRENCY,
            'cuenta' => $model->wallet_creditcard,
            'vence' => $model->wallet_expiration,
            'pin' => $model->wallet_pin,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ]);
        $post = json_encode($params_post);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    /**
     * @param $token
     * @param Withdraw $model
     * @return mixed
     */
    public static function extract($token,$model)
    {
        $endpoint = self::CURLUTIL_URL_API.'acortador/depositar/'.$model->wallet_user;
        $params_post = [
            'saldo' => $model->total_amount,
            'moneda' => self::CURLUTIL_CURRENCY,
            'user_id' => $model->user_id,
            'token' => $model->user->auth_key
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ]);

        $post = json_encode($params_post);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }
}