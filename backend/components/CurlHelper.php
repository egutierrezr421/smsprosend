<?php

namespace backend\components;

use Yii;

class CurlHelper
{
    /**
     * @param $url string
     * @param array $params
     * @param array $headers
     * @param bool $jsonDecode
     * @return array|mixed
     *
     * Headers Bearer example:
     * ['Content-Type: application/json' , 'Authorization: Bearer 080042cad6356ad5dc0a720c18b53b8e53d4c274'];
     */
    public static function post($url, $params, $headers=[], $jsonDecode=true)
    {
        if (empty($params) || !is_array($params)) {
            if($jsonDecode){
                return [
                    'message' => Yii::t("backend", "La petición no tiene ningún parámetro, por favor revise los datos a enviar.")
                ];
            }else{
                return Yii::t("backend", "La petición no tiene ningún parámetro, por favor revise los datos a enviar.");
            }
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$url");
            if(isset($headers) && is_array($headers) && !empty($headers)){
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            if($jsonDecode){
                $response = json_decode(curl_exec($ch), true);
            }else{
                $response = curl_exec($ch);
            }
            curl_close($ch);

        } catch (\Exception $e) {
            if($jsonDecode){
                $response = [
                    'message' => $e->getMessage()
                ];
            }else{
                $response = $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * @param $url string
     * @param array $params
     * @param array $headers
     * @param bool $jsonDecode
     * @return array|mixed
     *
     * Headers Bearer example:
     * ['Content-Type: application/json' , 'Authorization: Bearer 080042cad6356ad5dc0a720c18b53b8e53d4c274'];
     */
    public static function put($url, $params, $headers=[], $jsonDecode=true)
    {
        if (empty($params) || !is_array($params)) {
            if($jsonDecode){
                return [
                    'message' => Yii::t("backend", "La petición no tiene ningún parámetro, por favor revise los datos a enviar.")
                ];
            }else{
                return Yii::t("backend", "La petición no tiene ningún parámetro, por favor revise los datos a enviar.");
            }
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$url");
            if(isset($headers) && is_array($headers) && !empty($headers)){
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            if($jsonDecode){
                $response = json_decode(curl_exec($ch), true);
            }else{
                $response = curl_exec($ch);
            }
            curl_close($ch);

        } catch (\Exception $e) {
            if($jsonDecode){
                $response = [
                    'message' => $e->getMessage()
                ];
            }else{
                $response = $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * @param $url string
     * @param array $headers
     * @param bool $jsonDecode
     * @return array|mixed
     *
     * Headers Bearer example:
     * ['Content-Type: application/json' , 'Authorization: Bearer 080042cad6356ad5dc0a720c18b53b8e53d4c274'];
     */
    public static function get($url, $headers=[], $jsonDecode=true)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$url");
            if(isset($headers) && is_array($headers) && !empty($headers)){
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if($jsonDecode){
                $response = json_decode(curl_exec($ch), true);
            }else{
                $response = curl_exec($ch);
            }
            curl_close($ch);

        } catch (\Exception $e) {
            if($jsonDecode){
                $response = [
                    'message' => $e->getMessage()
                ];
            }else{
                $response = $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * @param $url string
     * @param array $params
     * @return array|mixed
     */
    public static function postWithoutCurl($url, $params, $jsonDecode = true)
    {
        if (empty($params) || !is_array($params)) {
            if($jsonDecode){
                return [
                    'message' => Yii::t("backend", "La petición no tiene ningún parámetro, por favor revise los datos a enviar.")
                ];
            }else{
                return Yii::t("backend", "La petición no tiene ningún parámetro, por favor revise los datos a enviar.");
            }
        }

        try {
            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($params),
                ),
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($jsonDecode) {
                $response = json_decode($result, true);
            } else {
                $response = $result;
            }

        } catch (\Exception $e) {
            if ($jsonDecode) {
                $response = [
                    'message' => $e->getMessage()
                ];
            } else {
                $response = $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * @param $url string
     * @return array|mixed
     */
    public static function getWithoutCurl($url, $jsonDecode = true)
    {
        try {
            $result = file_get_contents($url);
            if ($jsonDecode) {
                $response = json_decode($result, true);
            } else {
                $response = $result;
            }
        } catch (\Exception $e) {
            if ($jsonDecode) {
                $response = [
                    'message' => $e->getMessage()
                ];
            } else {
                $response = $e->getMessage();
            }
        }

        return $response;
    }

}