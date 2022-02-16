<?php
/**
 * Programa para efetuar a criação das estruturas de Request para a API.
 * Manual de Integração V1.9.pdf
*/

include_once 'requestBasicData.php';
error_reporting(1);

try {
    #Dados do header
    $headers = array(
        "authorization: {$key}"
    );


    #Inicia a chamada do CURL
    $curl = curl_init();

    // Configura os parâmetros para a chamada
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://ciot.api.staging.truckpay.io/user/companies',  
        CURLOPT_HTTPGET => true,
        CURLOPT_RETURNTRANSFER => 1,    
        CURLOPT_HTTPHEADER => $headers
    ]);

    // Armazena o retorno
    $response = curl_exec($curl);

   

    #Coleta informações do Curl
    curl_getinfo($curl);

    #Coleta os erros do retorno
    curl_errno($curl);

    #Encerra a conexão
    curl_close($curl);

    #Tratando o retorno
    $dataRet = json_decode($response);

    print_r($dataRet);exit;

}catch(Exception $e){
    $retorno = "ERROR";
    // echo 'Não pode ser completado a comunicação. '.$e->getMessage(),'\n';
}

print $retorno;
