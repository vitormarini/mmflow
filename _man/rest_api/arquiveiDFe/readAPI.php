<?php
/**
 * Armazenando o retorno dos XML
 *  Criado em 18/07/2022
 *  Author: Vitor Hugo Marini
 */

include_once 'requestArquivei.php';
include_once("../../../response/_readerXML/readerDANFE.php");
include_once("../../../_conection/_conect.php");

session_start();
$user_id = 3;#$_SESSION['user_id'];

 #Chamda da API
/**
 * #FUNÇAO PARA CONSULTA DOS ARQUIVOS CONTIDOS NA API - ARQUIVEI
 * * Variáveis:
 * @- $xInicial : valor inicial, semelhante com o NSU
 * @ - $xFinal   : valor final, semelhante ao LastNSU
 * @ - $xTipo    : tipoda consulta ( TIPOS VÁLIDOS nfe, nfse )
 */

// $arrxTipo = ['nfe','nfse','cte','events'];
$arrxTipo = ['nfe'];

foreach($arrxTipo as $tp){
    $nsu = $bd->Execute($sql = "SELECT lastnsu FROM t_dfe_service tds WHERE tipo = UPPER('{$tp}') ORDER BY id_t_dfe_service DESC LIMIT 1;");
    $xFinal = $nsu->fields['lastnsu'] + 50;
    $xFinal = 50;

    $readAPI = consultaArquivei("100","$xFinal","$tp");

    #Tratando os retornos.
    $confirmRet = $readAPI["retorno_mensagem"];
    $dataRet    = $readAPI["data"];

    #Lendo o retorno dos arrays
    if ( $confirmRet == "Ok" ){

        $bd->Execute($sql = "
            INSERT INTO public.t_dfe_service (
                data_consulta   , hora_consulta , user_consulta , lastnsu   , tipo
            )VALUES (
                current_date, current_time::time, {$user_id}, '{$xFinal}'   , UPPER('{$tp}')); ");

        $id_dfe = $bd->Insert_ID();

        $x = 1;
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

            /** Lendo o XML */
            $xml = loadFile($xmlDoc,$x,$id_dfe);

            /** Montando array para adicionar na tabela t_d */
            $xml['prot_nfe']["nsu"]     = (string) $nsu->fields['lastnsu'] + $x;
            $xml['prot_nfe']["id_dfe"]  = (string) $id_dfe;
            $xml['prot_nfe']["xml"]     = $xmlDoc;
            
            $json = json_encode($xml['prot_nfe'],true);

            $bd->Execute($sql = "SELECT crud_t_dfe_service_docs_('INSERT_','1','{$json}');");

            // print "<pre>"; print $sql;
            // exit;

            # Transforma o array em json para gravação do banco
            $json_nf = json_encode($xml,true);

            if(duplicity($chave_acesso)){
                $bd->Execute("SELECT crud_escrita_fiscal('INSERT_' , '1' , '{$json_nf}');");
            }

            $x++;
        }
        print "OK";
        exit;
    }else{
        print $readAPI["retorno_mensagem"];
        exit;
    }
}
function duplicity($chave_acesso){
    global $bd;
    $chave_acesso = explode(".",$chave_acesso)[0];    
    $nf = $bd->Execute($sql = "SELECT * FROM t_escrita_fiscal WHERE REPLACE(ef_ident,'NFe','') = '{$chave_acesso}'; --ef_num_nf = '76858' AND ef_cnpj_emit = '57208480000106' AND ef_tipo_op = '1';");
    if($nf->RecordCount() > 0)return false;
    
    return true;        
}
?>