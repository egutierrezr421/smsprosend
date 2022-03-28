<?php

namespace backend\components;

/**
 * QvaTel API v1.1
 * @author Yemil Godinez <yemilgr@gmail.com>
 */

class QvaTel
{
    //user credential 
    private $api_token;

	// REST API BASE URL
    private $rest_base_url = 'https://qvatel.com/api';
    
	private $rest_commands = array (
        //sms
        'send_sms' => array('url' => '/sms/send', 'method' => 'POST'),
        'get_sms_status' => array('url' => '/sms/report-status', 'method' => 'GET'),
        'get_balance' => array('url' => '/account/balance', 'method' => 'GET'),

        //recarga
        'send_recarga' => array('url' => '/recharge/send', 'method' => 'POST'),
        'get_recarga_balance' => array('url' => '/account/recharge-balance', 'method' => 'GET')
    );

    public function __construct($api_token = null)
    {
        $this->api_token = $api_token;
    }

	/**
	* Enviar SMS
	*/
    public function enviar_sms($destino, $mensaje)
	{
        //chequea longitud del mensaje
        if(strlen($mensaje) > 160){
            trigger_error('La longitud del mensaje sobrepasa los 160 caracteres.');
            return false;   
        }

        $data = array(
            'destino' => $destino,
            'mensaje' => $mensaje
        );

        return $this->callApi('send_sms', $data);
    }

    /**
    * Obtener un reporte de entrega del sms
    */
    public function reporte_sms($id_msg)
    {
        $data = array('id_msg' => $id_msg);
        return $this->callApi('get_sms_status', $data);
    }

    /**
    * Obtener el balance de la cuenta QvaTel
    */
    public function balance()
    {
        return $this->callApi('get_balance');
    }

    /**
	* Enviar Recarga
	*/
    public function enviar_recarga($destino, $monto)
    {
        $data = array(
            'destino' => $destino,
            'monto' => $monto
        );

        return $this->callApi('send_recarga', $data);
    }

    /**
    * Obtener el balance de recargas de la cuenta QvaTel
    */
    public function balance_recarga()
    {
        return $this->callApi('get_recarga_balance');
    }

    /**
    * Llamada a api de QvaTel
    */
    private function callApi($command, $data = array())
    {
        $command_info = $this->rest_commands[$command];
        $url = $this->rest_base_url . $command_info['url'];
        $method = $command_info['method'];

        $params = array_merge($data, array('api_token' => $this->api_token));
        $params_query_string = http_build_query($params);

        if(function_exists('curl_version')) //user curl
        {
            $request = curl_init();

            if($method == 'POST'){
                curl_setopt($request, CURLOPT_URL, $url);
                curl_setopt($request, CURLOPT_POST, true);
                curl_setopt($request, CURLOPT_POSTFIELDS, $params_query_string);
            }else{
                curl_setopt($request, CURLOPT_URL, $url.'?'.$params_query_string);
            }

            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);   
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($request);
            curl_close($request);

        }elseif (ini_get('allow_url_fopen')){ // No CURL available so try the awesome file_get_contents

            if($method == 'POST'){
                $opts = array('http' =>
                    array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $params_query_string
                    )
                );
                $context = stream_context_create($opts);
                $response = file_get_contents($url, null, $context);
            }else{
                $opts = array('http' =>
                    array(
                        'method'  => 'GET',
                    )
                );
                $context = stream_context_create($opts);
                $response = file_get_contents($url.'?'.$params_query_string, null, $context);                
            }

        }else {
            return false;
        }

        return $response;
    }
}