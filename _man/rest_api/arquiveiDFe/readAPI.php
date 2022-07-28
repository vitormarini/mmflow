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
$user_id = $_SESSION['user_id'];

 #Chamda da API
/**
 * #FUNÇAO PARA CONSULTA DOS ARQUIVOS CONTIDOS NA API - ARQUIVEI
 * * Variáveis:
 * @- $xInicial : valor inicial, semelhante com o NSU
 * @ - $xFinal   : valor final, semelhante ao LastNSU
 * @ - $xTipo    : tipoda consulta ( TIPOS VÁLIDOS nfe, nfse )
 */

$arrxTipo = ['nfe','nfse','cte','events'];
$y = 0;
foreach($arrxTipo as $tp){
    $nsu = $bd->Execute($sql = "SELECT lastnsu FROM t_dfe_service tds WHERE tipo = UPPER('{$tp}') ORDER BY id_t_dfe_service DESC LIMIT 1;");
    $xFinal = !empty($nsu->fields['lastnsu']) ? $nsu->fields['lastnsu'] : 50;

    $xTipo = ['/v1/nfe/received','/v1/events/nfe','/v1/nfse/received','/v1/cte/taker'];

    # Função que retorna a consulta 
    $readAPI = consultaArquivei("100","$xFinal","$xTipo[$y]");

    #Tratando os retornos.
    $confirmRet = strtoupper($readAPI["retorno_mensagem"]);
    $dataRet    = $readAPI["data"];

    #Lendo o retorno dos arrays
    if ( $confirmRet == "OK" ){

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

            if( $tp == "nfe" ){
                /** Lendo o XML */
                $xml = loadFile($xmlDoc);

                /** Montando array para adicionar na tabela t_d */
                $xml['prot']["nsu"]     = (string) $nsu->fields['lastnsu'] + $x;
                $xml['prot']["id_dfe"]  = (string) $id_dfe;
                $xml['prot']["xml"]     = $xmlDoc;

                # Transforma o array em json para gravação do banco
                $json_nf = json_encode($xml,true);

                if(duplicity($chave_acesso)){
                    $bd->Execute("SELECT crud_escrita_fiscal('INSERT_' , '1' , '{$json_nf}');");
                }
            }else if( in_array($tp,array("cte","events")) ){
                if( $tp == "cte" ){
                    $versao = $xmlDoc->protCTe->attributes()->versao;
                    $prot = $xmlDoc->protCTe->infProt;
                }else{
                    $versao = $xmlDoc->retEvento->attributes()->versao;
                    $prot = $xmlDoc->retEvento->infEvento;
                }

                $xml['prot'] = array(
                    'versao'        => (string) $versao
                   ,'tpamb'         => (string) $prot->tpAmb
                   ,'veraplic'      => (string) $prot->verAplic
                   ,'chnfe'         => (string) $prot->chNFe
                   ,'dhrecbto'      => (string) $prot->dhRecbto
                   ,'nprot'         => (string) $prot->nProt
                   ,'digval'        => (string) $prot->digVal
                   ,'cstat'         => (string) $prot->cStat
                   ,'xmotivo'       => (string) $prot->xMotivo
                   ,'nsu'           => (string) $nsu->fields['lastnsu'] + $x
                   ,'id_dfe'        => (string) $id_dfe
                   ,'xml'           => $xmlDoc
                   ,'tpevento'      => (string) $prot->tpEvento
                   ,'xevento'       => (string) $prot->xEvento
                   ,'dhregevento'   => (string) $prot->dhRegEvento
                   ,'corgao'        => (string) $prot->cOrgao
                   ,'cnpjdest'      => (string) $prot->CNPJDest
                );
            }
            
            $json = str_replace("'", "''", json_encode($xml['prot'],true));
            $bd->Execute($sql = "SELECT crud_t_dfe_service_docs_('INSERT_','1','{$json}');");

            $x++;
        }
    }else{
        print $readAPI["retorno_mensagem"];
        exit;
    }
    $y++;
}
print "OK";
exit;

# Função que verifica a duplicidade da NFe
function duplicity($chave_acesso){
    global $bd;
    $chave_acesso = explode(".",$chave_acesso)[0];    
    $nf = $bd->Execute($sql = "SELECT * FROM t_escrita_fiscal WHERE REPLACE(ef_ident,'NFe','') = '{$chave_acesso}'; --ef_num_nf = '76858' AND ef_cnpj_emit = '57208480000106' AND ef_tipo_op = '1';");
    if($nf->RecordCount() > 0)return false;
    
    return true;        
}
?>