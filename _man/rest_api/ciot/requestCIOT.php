<?php
/**
 * Programa para efetuar a criação das estruturas de Request para a API.
 * Manual de Integração V1.9.pdf
*/

include_once 'requestBasicData.php';
error_reporting(1);

$token = "";

try {
    #Dados para o Post 
    $dataPost = [
        'user_email'    => $email,
        'user_password' => $senha
    ];

    #Transformando o array em Json
    $dataJson = json_encode($dataPost);

    #Dados do header
    $headers = array(
        "Content-Type: {$content}",
        "authorization: {$autho}",
        "company: {$key}"
    );

    #Inicia a chamada do CURL
    $curl = curl_init();

    // Configura os parâmetros para a chamada
    curl_setopt_array($curl, [
        CURLOPT_URL => $urlRequest.'/login/external',    
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => 1,    
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $dataJson
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

    $codigo_message = $dataRet->cod_message;
    $message        = $dataRet->message;
    $company_id     = $dataRet->data->company_id;
    $token          = $dataRet->data->token;

    $retorno = "SUCESSO";

}catch(Exception $e){
    $retorno = "ERROR";    
}