<?php
/**
 * Armazenando o retorno dos XML
 *  Criado em 18/07/2022
 *  Author: Vitor Hugo Marini
 */

include_once 'requestArquivei.php';
include_once("../../../response/_readerXML/readerDANFE.php");
include_once("../../../_conection/_conect.php");
include_once("../../../_man/_aux.php");

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

function readAPI($readAPI,$tp,$xFinal,$nsu){
    global $bd;
    global $user_id;

    error_reporting(1);

    # Decodificação
    $readAPI = json_decode($readAPI,true);

    #Tratando os retornos.
    $confirmRet = strtoupper($readAPI['status']["message"]);
    $dataRet    = $readAPI["data"];       
    
    print "<pre>"; print_r($readAPI);
    // print "<pre>"; print_r($dataRet);
    exit;

    #Lendo o retorno dos arrays
    if ( $confirmRet == "OK" ){        

        $xFinal += 50;

        $bd->Execute($sql = "
            INSERT INTO public.t_dfe_service (
                data_consulta   , hora_consulta , user_consulta , lastnsu   , tipo
            )VALUES (
                current_date, current_time::time, {$user_id}, '{$xFinal}'   , UPPER('{$tp}')); ");

        $id_dfe = $bd->Insert_ID();
        
        $x = 1;
        foreach ($dataRet as $retXml){

            // print "<pre>"; print_r("tamara aq");
            // print "<pre>"; print_r($retXml['xml']);
            //     exit;

            #Conferir a chave e o XML se já não estão gravados no banco
            $chave_acesso  = $retXml['access_key'];

            #Validar o XML 
            $xmlRet = $retXml['xml'];

            #Descompactar o XMl e Ler - Conferindo a existencia, validação do banco
            /**
             * Formas de abrir o XML
             */
            $xmlDoc  = simplexml_load_string(base64_decode($xmlRet));
            $xmlJson = json_decode(json_encode((array)$xmlDoc,true));

            // print "<pre>xml "; print_r($xmlRet);
            //     exit;

            if( $tp == "nfe" ){
                /** Lendo o XML */
                $xml = loadFile($xmlDoc);

                /** Montando array para adicionar na tabela t_d */
                $xml['prot']["nsu"]     = (string) $nsu + $x;
                $xml['prot']["id_dfe"]  = (string) $id_dfe;
                $xml['prot']["xml"]     = $xmlDoc;

                # Transforma o array em json para gravação do banco
                $json_nf = json_encode($xml,true);

                // print "<pre>"; print_r($json_nf);
                // exit;

                if(duplicity($chave_acesso)){
                    $bd->Execute($sql = "SELECT crud_escrita_fiscal('INSERT_' , '1' , '{$json_nf}');");            
                    print "<pre>SQL "; print $sql;                        
                }

                // print "<pre>id "; print $sql;
                // exit("tamara");
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
                   ,'nsu'           => (string) $nsu + $x
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
            print "<pre>SQL2 "; print $sql;    

            $x++;
        }
        // print "OK aq";
    }else{
        print $readAPI['status']["message"];
        exit;
    }
}

# Função que verifica a duplicidade da NFe
function duplicity($chave_acesso){
    global $bd;
    $chave_acesso = explode(".",$chave_acesso)[0];

    $nf = $bd->Execute($sql = "SELECT * FROM t_escrita_fiscal WHERE REPLACE(ef_ident,'NFe','') = '{$chave_acesso}';");
    if($nf->RecordCount() > 0)return false;
    
    return true;        
}
?>