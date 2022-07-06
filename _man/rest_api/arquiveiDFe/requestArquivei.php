<?php
/**
 * Programa para integração das API`s Software Arquivei
 * Manual de Integração V1.9.pdf
*/

include_once 'requestBasicData.php';
error_reporting(1);

$inicial = ( isset($_GET['inicial']) && !empty($_GET['inicial']) ? $_GET['inicial'] : "0");
$final   = ( isset($_GET['final'])   && !empty($_GET['final'])   ? $_GET['final']   : "50");
$tipo    = ( isset($_GET['tipo'])    && !empty($_GET['tipo'])    ? $_GET['tipo']    : "nfe");

try {
    #Dados para o Post 
    $dataPost = "";

    #Transformando o array em Json
    $dataJson = json_encode($dataPost);

    $endPoint      = "/v1/$tipo/received";

    #Dados do header
    $headers = array(
        "X-API-ID: {$xAPI_ID}",
        "X-API-KEY: {$xAPI_KEY}",
        "Content-Type: application/json"
    );

    #Definindo os limites da pesquisa
    // $cursorLimit = "?cursor=$inicial&limit=$final";
    $cursorLimit = "?from=2019-09-12&to=now&cursor=$inicial&limit=$final";

    #Inicia a chamada do CURL
    $curl = curl_init();

    // Configura os parâmetros para a chamada
    curl_setopt_array($curl, [
        CURLOPT_URL => $urlRequest.$endPoint.$cursorLimit,    
        CURLOPT_POST => false,
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

    #Tratamento do retorno
    if ( $dataRet->status->code == "200" ){

        #Tratamento do retorno com SUCESSO!
        $retorno = array(
            "retorno_codigo"    => $codigoMensagem,
            "retorno_mensagem"  => $dataRet->status->message,
            "nextData"          => $dataRet->page->next,
            "previusData"       => $dataRet->page->previous,
            "countador"         => $dataRet->count,
            "signature"         => $dataRet->signature,
            "data"              => $dataRet->data
        );
    }else{
        #Tratamento para retornos que não tiveram sucesso!
        $retorno = array(
            "retorno_codigo"    => $codigoMensagem,
            "retorno_mensagem"  => $dataRet->status->message
        );
    }

    print"<pre>";
    print_r($retorno);
    exit;

    $retorno = "SUCESSO";

}catch(Exception $e){
    $retorno = "ERROR";    
}