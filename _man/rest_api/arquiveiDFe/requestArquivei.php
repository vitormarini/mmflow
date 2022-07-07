<?php
/**
 * Programa para integração das API`s Software Arquivei
 * Documentação disposta pela Arquivei
 * https://developers.arquivei.com.br/docs/get/v1/nfe/received
 * Data: 06/07/2022
*/

#Exemplo de chamada
#$consultaNfe = consultaArquivei("100","50","nfe");  -- Retorno será um Array

/**
 * #FUNÇAO PARA CONSULTA DOS ARQUIVOS CONTIDOS NA API - ARQUIVEI
 * * Variáveis:
 * @ - $xInicial : valor inicial, semelhante com o NSU
 * @ - $xFinal   : valor final, semelhante ao LastNSU
 * @ - $xTipo    : tipoda consulta ( TIPOS VÁLIDOS nfe, nfse )
 */
function consultaArquivei($xInicial, $xFinal, $xTipo){


    include_once 'requestBasicData.php';
    error_reporting(1);

    $inicial = ( isset($xInicial) && !empty($xInicial) ? $xInicial : "0");
    $final   = ( isset($xFinal)   && !empty($xFinal)   ? $xFinal   : "50");
    $tipo    = ( isset($xTipo)    && !empty($xTipo)    ? $xTipo    : "nfe");

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
        $cursorLimit = "?cursor=$inicial&limit=$final";
        // $cursorLimit = "?from=2019-09-12&to=now&cursor=$inicial&limit=$final";

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

    }catch(Exception $e){
        $retorno = "ERROR";    
    }

    return $retorno;
}