<?php
/**
 * Armazenando o retorno dos XML
 *  Criado em 18/07/2022
 *  Author: Vitor Hugo Marini
 */

 include_once 'requestArquivei.php';

 #Chamda da API
/**
 * #FUNÇAO PARA CONSULTA DOS ARQUIVOS CONTIDOS NA API - ARQUIVEI
 * * Variáveis:
 * @- $xInicial : valor inicial, semelhante com o NSU
 * @ - $xFinal   : valor final, semelhante ao LastNSU
 * @ - $xTipo    : tipoda consulta ( TIPOS VÁLIDOS nfe, nfse, cte e events )
 */
 $readAPI = consultaArquivei("100","50","nfe");

 #Tratando os retornos.
 $confirmRet = $readAPI["retorno_mensagem"];
 $dataRet    = $readAPI["data"];


 #Lendo o retorno dos arrays
 if ( $confirmRet == "Ok" || $confirmRet == "OK" ){

    foreach ($dataRet as $retXml){

        #Conferir a chave e o XML se já não estão gravados no banco
        $chave  = $retXml->access_key;

        #Validar o XML 
        $xmlRet = $retXml->xml;

        #Descompactar o XMl e Ler - Conferindo a existencia, validação do banco
        /**
         * Formas de abrir o XML
         */
        $xmlDoc  = simplexml_load_string(base64_decode($xmlRet));
        $xmlJson = json_decode(json_encode((array)$xmlDoc,true));
        // $xmlArray = xml2array($xmlDoc);

        print"<pre>";
        print_r($xmlDoc);
        // exit;
      
    }
        
}
?>