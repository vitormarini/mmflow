<?php
/**
 * Programa para integração das API`s Software Arquivei
 * Documentação disposta pela Arquivei
 * https://developers.arquivei.com.br/docs/get/v1/nfe/received
 * Data: 06/07/2022
*/

include_once("./../../../_conection/_conect.php");
include_once("./readAPI.php");

session_start();
$user_id = $_SESSION['user_id'];

#Exemplo de chamada
// $consultaNfe = consultaArquivei("100","50","nfe");  

/**
 * #FUNÇAO PARA CONSULTA DOS ARQUIVOS CONTIDOS NA API - ARQUIVEI
 * * Variáveis:
 * @ - $xInicial : valor inicial, semelhante com o NSU
 * @ - $xFinal   : valor final, semelhante ao LastNSU
 * @ - $xTipo    : tipoda consulta ( TIPOS VÁLIDOS nfe, nfse )
 */



// $xTipo = ['/v1/nfe/received','/v1/events/nfe','/v1/nfse/received','/v1/cte/taker'];
$xTipo = ['/v1/nfe/received'];

# Função que retorna a consulta 
$readAPI = consultaArquivei();

function consultaArquivei(){
    global $bd;
   
    include_once 'requestBasicData.php';
    error_reporting(1);
    
    try {
        #Dados para o Post 
        $dataPost = "";

        #Transformando o array em Json
        $dataJson = json_encode($dataPost);

        // $endPoint      = "/v1/$tipo/received";//"/v1/cte/taker";
        $endPoint      = $tipo;

        #Dados do header
        $headers = array(
            "X-API-ID: {$xAPI_ID}",
            "X-API-KEY: {$xAPI_KEY}",
            "Content-Type: application/json"
        );

        #Definindo os limites da pesquisa
        // $cursorLimit = "?cursor=$inicial&limit=$final";
        // $cursorLimit = "?cursor=$inicial&limit=$final";
        // $cursorLimit = "?from=2019-09-12&to=now&cursor=$inicial&limit=$final";

        #Inicia a chamada do CURL
        $curl = curl_init();

        // $arrxTipo = ['nfe','nfse','cte','events'];
        $arrxTipo = ['nfe'];
        $t = 0;
        foreach($arrxTipo as $tp){

            # Array com o complemento da URL
            $xTipo = ['/v1/nfe/received','/v1/events/nfe','/v1/nfse/received','/v1/cte/taker'];

            $nsu = $bd->Execute($sql = "SELECT lastnsu FROM t_dfe_service tds WHERE tipo = UPPER('{$tp}') ORDER BY id_t_dfe_service DESC LIMIT 1;");
            $xFinal = !empty($nsu->fields['lastnsu']) ? $nsu->fields['lastnsu'] : 50;

            $xInicial = $nsu->fields['lastnsu'] + 50;

            $inicial = ( isset($xInicial) && !empty($xInicial)  ? $xInicial : "100");
            $final   = ( isset($xFinal)   && !empty($xFinal)    ? $xFinal   : "50");
            $tipo    = ( isset($xTipo)    && !empty($xTipo[$t]) ? $xTipo[$t]    : "nfe");
           
            $cursorLimit = "?cursor=$inicial&limit=50";

            // Configura os parâmetros para a chamada
            curl_setopt_array($curl, [
                CURLOPT_URL => $urlRequest.$xTipo[$t].$cursorLimit, 
                CURLOPT_RETURNTRANSFER => 1,    
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => $headers
            ]);

            // Armazena o retorno
            $response = curl_exec($curl);

            // print "<pre>"; print_r($response);
            // print "<pre>"; print_r($dataRet);
            // exit;
            
            readAPI($response,$tp,$xFinal,$nsu->fields['lastnsu']);
        }
        $t++;

        #Coleta informações do Curl
        curl_getinfo($curl);
        
        #Coleta os erros do retorno
        curl_errno($curl);

        #Encerra a conexão
        curl_close($curl);

        #Tratando o retorno
        $dataRet = json_decode($response);

        // print "<pre>"; print_r($dataRet);

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
        print "OK";
    }catch(Exception $e){
        $retorno = "ERROR";    
    }

    return $retorno;
}