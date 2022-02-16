<?php
/**
 * Estrutura Embasada em - https://github.com/vitormarini/send-mail
 * Author: Vitor Hugo Marini
 * Data Criação: 24/03/2021
 * Programa responsável por:
 *  - Consultar via SOAP dados emitidos contra o CNPJ da empresa setada.
 *  - Manifestar a Ciência da Operação sobre os dados coletados da SEFAZ.
 *  - Efetuar o Download dos Documentos solicitados, tanto em LOTE ou individual.
 */

require_once "../vendor/autoload.php";
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

include_once( './ControllerSefaz.php' );
include_once( '../_conection/_bd.php' );
include_once( '../_man/_aux.php' );
//include_once( './reponseFont.php' );
//include_once( '../request/requestEmail.php' );

#Buscando a empresa
//$dadosEmpresa       = $bd->Execute($sql = "SELECT cgc, razao_social FROM empresas  WHERE id_empresa = {$_SESSION['empresa']};");
//$cnpjEmpresa        = $dadosEmpresa->fields['cgc'];
$dataConsulta       = date("Y-m-d");
$horaConsulta       = date("H:i:s");
$statusConsulta     = $imprime = $timeOut = false;

$config      = requestConfig('43533233000162', 'LINKSYM');
$configJson  = json_encode($config);
$content     = file_get_contents('../certificado/40322434840_000001010600220.pfx');
$password    = 'zokt@322';  

$_POST['consultSefas'] = true;

#Validar tipo da requisição
$consultaSefaz      = ( $_POST['consultSefas']                           ? true  : false );
$efetuaDownload     = ( $_POST['dfeDownload']                            ? true  : true  );

$_POST['tipoBusca'] = "geral";

$tools = new Tools($configJson, Certificate::readPfx("53336244000106.pfx", "lino1748"));

print "<pre>";
print_r($_POST);
exit;

// Consulta Sefaz - Verificando e resgatando os Documentos encontrados
if ( $_POST['tipoBusca'] == "geral" ){
    
    if ( $consultaSefaz ){

        #Verificando a última Consulta
        #$lastConsult = $bd->Execute($sql = "SELECT hora_consulta, id_t_dfe_service, lastnsu FROM t_dfe_service WHERE data_consulta = '{$dataConsulta}' ORDER BY 1 DESC LIMIT 1;");
        #$lasNsu      = $bd->Execute($sql = "SELECT nsu::int AS lastnsu FROM t_dfe_service_docs WHERE nsu != '' ORDER BY id_t_dfe_service_docs DESC LIMIT 1;");

        $diffTIme = gmdate('H:i:s', strtotime(date("H:i:s")) - strtotime(date('H:i:s')));      
        /*
        if ( $lastConsult->RecordCount() <= 0 ){    
            $bd->Execute("INSERT INTO t_dfe_service ( data_consulta, hora_consulta, user_consulta, lastnsu ) VALUES ('{$dataConsulta}', '{$horaConsulta}', '{$_SESSION['id_usuario']}', '{$lasNsu->fields['lastnsu']}');");
            $lastConsult    = $bd->Execute($sql = "SELECT hora_consulta, id_t_dfe_service, lastnsu FROM t_dfe_service WHERE data_consulta = '{$dataConsulta}' ORDER BY 1 DESC LIMIT 1;");
            $statusConsulta = true;
        }
        //Verificamos se o prazo da consulta exedeu uma hora 
        else if (strtotime($diffTIme) <= strtotime("01:00:00") ){   
            $statusConsulta = true;
            $timeOut        = false;
        }
        //Verifica o Time Out    
        else{
            $timeOut        = false;
            $statusConsulta = true;
        }
        */
        $timeOut        = false;
        $statusConsulta = true;

        //Validando o Time Out
        if ( !$timeOut ){
//            exit("tmara");
            
            //Acessando e configurando o Certificado Digital
            $tools = new Tools($configJson, Certificate::readPfx("53336244000106.pfx", "lino1748"));

            //Único modelo de nota que é favorecido para esse tipo de Consulta além de rodar somente em ambiente de PRODUÇÃO
            $tools->model('55');
            $tools->setEnvironment(1);

            print"Vitor";
            exit;
            
            //Atualizamos esses valores de NSU para validar a quantidade de Documentos resgatados e não vir repetido as mesmas informações.
            $ultNSU    = $lastConsult->fields['lastnsu'];
            $maxNSU    = $ultNSU;
            $loopLimit = 50;
            $iCount    = 0;                  

            //Iniciando a sequencia de Consultas dos Documentos da RFB
            while ($ultNSU <= $maxNSU) {

                # Aqui validamos as consultas para não estourar o contador.
                $iCount++;
                if ($iCount >= $loopLimit) { break; }

                //Valida a chamada da Consulta e Reporta o erro, tendo que tratar.
                try {        
                    if ( $statusConsulta ){

                        $dataConsulta       = date("Y-m-d");   
                        $horaConsulta       = date("H:i:s");

                        //Atualizando o valor da última consulta
                        $bd->Execute("INSERT INTO t_dfe_service ( data_consulta, hora_consulta, user_consulta, lastnsu ) VALUES ('{$dataConsulta}', '{$horaConsulta}', '{$_SESSION['id_usuario']}', '{$ultNSU}');");          
                        $resp = $tools->sefazDistDFe($ultNSU);        # tamara   
                        $_SESSION["dfe_retorno"] = $resp;

                    }else{
                        $resp = $_SESSION["dfe_retorno"];
                    }    

                    //Armazeno a última consulta sempre.
                    $_SESSION["dfe_retorno"] = $resp;
                } catch (\Exception $e) {                
                    $timeOut = true;
                }

                if ( !$timeOut ){

                    #Leitura do XML pelo DOM
                    $dom = new \DOMDocument();
                    $dom->loadXML($resp);

                    $node       = $dom->getElementsByTagName('retDistDFeInt')->item(0);
                    $tpAmb      = $node->getElementsByTagName('tpAmb')->item(0)->nodeValue;
                    $verAplic   = $node->getElementsByTagName('verAplic')->item(0)->nodeValue;
                    $cStat      = $node->getElementsByTagName('cStat')->item(0)->nodeValue;
                    $xMotivo    = $node->getElementsByTagName('xMotivo')->item(0)->nodeValue;
                    $dhResp     = $node->getElementsByTagName('dhResp')->item(0)->nodeValue;
                    $ultNSU     = $node->getElementsByTagName('ultNSU')->item(0)->nodeValue;
                    $maxNSU     = $node->getElementsByTagName('maxNSU')->item(0)->nodeValue;
                    $lote       = $node->getElementsByTagName('loteDistDFeInt')->item(0);

                    # Valida o Lote, caso esteja vazio, refaz a consulta
                    if (empty($lote)) { continue; }

                    #Variável que recebe o valor do documento ZIP
                    $docs = $lote->getElementsByTagName('docZip');

                    foreach ($docs as $doc) {    
                        # Pegamos o número inicial e Final de Cada resgate dos documentos
                        $numnsu = $doc->getAttribute('NSU');

                        # Recuperamos o valor do Schema -- Válido para atualizações e versionamento de Layout
                        $schema = $doc->getAttribute('schema');        

                        # Recuperamos os valores do documento da forma compactada.
                        $content = gzdecode(base64_decode($doc->nodeValue)); #** tamara

                        # Identificando o Tipo de Documento
                        $tipo = substr($schema, 0, 6);

                        //Trazendo o XML bruto em Standerize ( array )
                        $st = new Standardize(); #*** tamara
                        $std = $st->toStd($content);

                        // -- Definindo o tipo resNFe
                        if ( $tipo == 'resNFe'  ){

                            #Organizando os dados que serão gravados na base.
                            $chNFe       = $std->chNFe;
                            $cnpj        = $std->CNPJ;
                            $xNome       = $std->xNome;
                            $ie          = $std->IE;
                            $tpNF        = $std->tpNF;
                            $vNF         = $std->vNF;
                            $dhRecbto    = $std->dhRecbto;
                            $nProt       = $std->nProt;
                            $cSitNfe     = $std->cSitNFe;
                            $digVal      = $std->digVal;
                            $arquivo     = $chNFe."--{$tipo}.xml";      
                            $xSchema     = $tipo;

                            //Dados que são vazios pra essa condição
                            $cUF         = "";                $cNF         = "";
                            $serie       = "";                $mod         = "";
                            $dhEmi       = "";                $verAplic    = "";
                            $cStat       = "";                $xMotivo     = "";   
                            $idEvento    = "";                $verAplic    = "";
                            $tpEvento    = "";                $xEvento     = "";
                            $nSeqEvento  = "";                $dhRegEvento = "";
                            $dhEvento    = "";

                            $imprime = false;
                        }
                        // -- Definindo o tipo procNF
                        else if ( $tipo == "procNF" ){

                            #Organizando os dados que serão gravados na base.
                            $chNFe       = $std->protNFe->infProt->chNFe;
                            $cnpj        = $std->NFe->infNFe->emit->CNPJ;
                            $xNome       = $std->NFe->infNFe->emit->xNome;
                            $ie          = $std->NFe->infNFe->emit->IE;
                            $tpNF        = $std->NFe->infNFe->ide->tpNF;
                            $vNF         = $std->NFe->infNFe->total->ICMSTot->vNF;
                            $dhRecbto    = $std->protNFe->infProt->dhRecbto;
                            $nProt       = $std->protNFe->infProt->nProt;            
                            $digVal      = $std->protNFe->infProt->digVal;
                            $arquivo     = $chNFe."--{$tipo}.xml";     
                            $cUF         = $std->NFe->infNFe->ide->cUF;
                            $cNF         = $std->NFe->infNFe->ide->cNF;
                            $serie       = $std->NFe->infNFe->ide->serie;
                            $mod         = $std->NFe->infNFe->ide->mod;
                            $dhEmi       = $std->NFe->infNFe->ide->dhEmi;
                            $verAplic    = $std->protNFe->infProt->verAplic;
                            $cStat       = $std->protNFe->infProt->cStat;
                            $xMotivo     = $std->protNFe->infProt->xMotivo; 
                            $xSchema     = $tipo;
                            $idEvento    = $std->NFe->infNFe->attributes->Id;

                            //Dados que são vazios pra essa condição
                            $cSitNfe     = "";                $tpEvento    = "";
                            $xEvento     = "";                $nSeqEvento  = "";
                            $dhRegEvento = "";                $dhEvento    = "";

                            $imprime = false;
                        }
                        // -- Definindo o tipo procEv
                        else if ( $tipo == 'procEv' ){

                            #Organizando os dados que serão gravados na base.
                            $chNFe       = $std->evento->infEvento->chNFe;
                            $cnpj        = $std->evento->infEvento->CNPJ;                                    
                            $nProt       = $std->retEvento->infEvento->nProt;            
                            $arquivo     = $chNFe."--{$tipo}.xml";      
                            $xSchema     = $tipo;
                            $idEvento    = $std->evento->infEvento->attributes->Id;
                            $xMotivo     = $std->retEvento->infEvento->xMotivo;
                            $cStat       = $std->retEvento->infEvento->cStat;
                            $verAplic    = $std->retEvento->infEvento->verAplic;
                            $tpEvento    = $std->retEvento->infEvento->tpEvento;
                            $xEvento     = $std->retEvento->infEvento->xEvento;
                            $nSeqEvento  = $std->retEvento->infEvento->nSeqEvento;
                            $dhRegEvento = $std->retEvento->infEvento->dhRegEvento;
                            $dhEvento    = $std->retEvento->infEvento->dhEvento;

                            //Dados que são vazios pra essa condição
                            $xNome       = "";                $ie          = "";
                            $tpNF        = "";                $vNF         = "0";
                            $dhRecbto    = "";                $cSitNfe     = "";
                            $digVal      = "";

                            $cUF        = "";                $cNF        = "";
                            $serie      = "";                $mod        = "";
                            $dhEmi      = "";                $tpNF       = "";
                            $verAplic   = "";

                            $imprime = false;
                        }
                        // -- Definindo o tipo resEve
                        else if ( $tipo == 'resEve' ){

                            #Organizando os dados que serão gravados na base.
                            $chNFe       = $std->chNFe;
                            $cnpj        = $std->CNPJ;            
                            $dhEvento    = $std->dhEvento;
                            $tpEvento    = $std->tpEvento;
                            $nSeqEvento  = $std->nSeqEvento;
                            $xEvento     = $std->xEvento;
                            $dhRecbto    = $std->dhRecbto;            
                            $nProt       = $std->nProt;                                                                        
                            $arquivo     = $chNFe."--{$tipo}.xml";      
                            $xSchema     = $tipo;

                            //Dados que são vazios pra essa condição
                            $cUF         = "";                $cNF         = "";
                            $serie       = "";                $mod         = "";
                            $dhEmi       = "";                $verAplic    = "";
                            $cStat       = "";                $xMotivo     = "";   
                            $idEvento    = "";                $verAplic    = "";            
                            $dhRegEvento = "";                $digVal      = "";
                            $cSitNfe     = "";                $xNome       = "";
                            $ie          = "";                $tpNF        = "";
                            $vNF         = "0";

                            $imprime = false;
                        }
                        else {
                            print($tipo."</br>");
                            exit;
                        }

                        //Validando se o evento já foi gravado
                        $dadosValid = $bd->Execute($sql = "SELECT id_t_dfe_service_docs FROM t_dfe_service_docs WHERE chnfe = '{$chNFe}' AND nprot = '{$nProt}' AND tipo = '{$xSchema}';");

                        if ( $dadosValid->RecordCount() <= 0 ){

                            //Após a leitura do Documento vamos gravar no banco de dados
                            $bd->Execute($sql = 
                            "INSERT INTO public.t_dfe_service_docs
                                (chnfe                                          , cnpj          , nome          , ie            , tpnf          , vnf            , dhrecbto          , nprot         , digval
                               , path                                           , cuf           , cnf           , serie         , mod           , dhemi          , veraplic          , cstat         , xmotivo
                               , tipo                                           , id_evento     , csitnfe       , tpevento      , xevento       , nseqevento     , dhregevento       , dhevento      , status
                               , id_t_dfe_service                               , nsu)
                            VALUES(
                                '{$chNFe}'                                      , '{$cnpj}'     , '{$nome}'     , '{$ie}'       , '{$tpNF}'     , '{$vNF}'       , '{$dhRecbto}'     , '{$nProt}'    , '{$digVal}'
                              , '{$arquivo}'                                    , '{$cUF}'      , '{$cNF}'      , '{$serie}'    , '{$mod}'      , '{$dhEmi}'     , '{$verAplic}'     , '{$cStat}'    , '{$xMotivo}'
                              , '{$tipo}'                                       , '{$idEvento}' , '{$cSitNfe}'  , '{$tpEvento}' , '{$xEvento}'  , '{$nSeqEvento}', '{$dhRegEvento}'  , '{$dhEvento}' , 'ABERTO'
                              , {$lastConsult->fields['id_t_dfe_service']}      , '{$numnsu}');");

                        }       

                        //Auxiliar na impressão para validações
                        if ( $imprime ){
                            print"<pre>";
                            print_r($std);
                            exit;
                        }

                    }
                }else{
                    $ultNSU ++;
                }

                #AQUI Validamos o LOOP, tomando cuidado pra não ficar Infinito
                if ($ultNSU == $maxNSU) {
                   break; //CUIDADO para não deixar seu loop infinito !!
                }
                sleep(2);

            }
            
            //Consultando o E-mail para efetuar o download de Notas Fiscais emitidas e que estão no E-mail
            requestEmail("nfe");    
        }   
    }
    
    
    // Efetua o Download de TODOS ou de um Documento específico os Documentos
    if ( $efetuaDownload ){
        
        requestEmail("nfe");   
        
        $andWhere = $_POST['ch'] != "" ? "WHERE chnfe = '{$_POST['ch']}'" : "WHERE status IN ( 'ABERTO' , 'CIENCIA_OPERACAO' )";
        $dataXML = $bd->Execute($sql = 
        "SELECT chnfe, substring(dhrecbto,1,4) AS ano, substring(dhrecbto, 6,2) AS mes, status 
          FROM  t_dfe_service_docs 
          {$andWhere} 
          AND   tipo IN ( 'resNFe','procNF' )   
          AND   chnfe NOT IN ( SELECT chnfe FROM t_dfe_service_docs WHERE status = 'CIENCIA_OPERACAO_DOWNLOAD')  
          ORDER BY substring(dhrecbto, 6,2) DESC 
          LIMIT 20;");                         
        
        # - VALIDANDO DADOS
        while ( !$dataXML->EOF ){

             $status = $dataXML->fields['status'];


             while ( $status == "ABERTO" ){

                 sendCienciaOp($dataXML->fields['chnfe'], '', "210200", $_SESSION['id_usuario'], $configJson, $content, $password, "", $dadosEmpresa->fields['cgc']);

                 $buscaStatus = $bd->Execute("SELECT status FROM t_dfe_service_docs WHERE chnfe = '{$dataXML->fields['chnfe']}' GROUP BY 1;");
                 $status = $buscaStatus->fields['staDomingãotus'];
             } 

            sefazDownloadDFe($dataXML->fields['chnfe'], $configJson, $content, $password, $dataXML->fields['mes'], $dataXML->fields['ano'], $cnpjEmpresa,"");

            $dataXML->MoveNext();
        }

    }
}


#Tratamos a validação para a Manifestação da Ciência e Download do arquivo do tipo Proc
if ( $_POST['tipoBusca'] == "unica" ){
    
    #AQUI VALIDAMOS SE A CHAVE JÁ FOI DADA CIÊNCIA DA OPERAÇÃO
    $dataXML = $bd->Execute($sql = "SELECT chnfe, substring(dhrecbto,1,4) AS ano, substring(dhrecbto, 6,2) AS mes, status FROM t_dfe_service_docs WHERE tipo = 'procNF' AND chnfe = '{$_POST['ch']}' ORDER BY substring(dhemi,1,10)::Date;");                         
    
    $statusDFe = $dataXML->RecordCount() <= 0 ? "ABERTA" : $dataXML->fields['status'];
    
    $cont = 0;
    while ( ( $statusConsulta != "CIENCIA_OPERACAO" && $statusConsulta != "CIENCIA_OPERACAO_DOWNLOAD") || $cont <= 1 ){
        
        
        $verificaCiencia = $bd->Execute($sql = 
        "SELECT chave_acesso_consultada 
           FROM nota_manifesto_destinatario nmd 
          WHERE cstat = '999' 
            AND chave_acesso_consultada NOT IN ( SELECT chave_acesso_consultada FROM nota_manifesto_destinatario nmd WHERE cstat = '135' ) 
            AND chave_acesso_consultada = '{$_POST['ch']}'");
            
         if ( $verificaCiencia->RecordCount() > 0 ){
            sendCienciaOp($_POST['ch'], '', "210200", $_SESSION['id_usuario'], $configJson, $content, $password, "",$dadosEmpresa->fields['cgc']);  
         }
        
        $mes = substr($_POST['ch'],4,2);
        
        $down = sefazDownloadDFe($_POST['ch'], $configJson, $content, $password, $mes, $_SESSION['ano_oper'], $cnpjEmpresa,"unica");  
        
        
        
        if ( $down == "FAULT_TIME_OUE" ){
            sendCienciaOp($_POST['ch'], '', "210200", $_SESSION['id_usuario'], $configJson, $content, $password, "",$dadosEmpresa->fields['cgc']);  
            
             $dataXML = $bd->Execute($sql = "SELECT status FROM t_dfe_service_docs WHERE tipo = 'resNFe' AND chnfe = '{$_POST['ch']}';");
        
        
            $statusConsulta = $dataXML->fields['status'];
        }else{
            $statusConsulta = "CIENCIA_OPERACAO_DOWNLOAD";
        }
        
        $cont ++;
    
    }
    
    
    #Rodamos o LOOP até ele efetuar o Download.
    $sql = "SELECT status FROM t_dfe_service_docs WHERE tipo = 'procNF' AND chnfe = '{$_POST['ch']}' AND status = 'CIENCIA_OPERACAO_DOWNLOAD';";
    $dataXML = $bd->Execute($sql);    
    $baixou  = $dataXML->RecordCount() > 0 ? true : false;
    
    while ( !$baixou ){
    
        sefazDownloadDFe($_POST['ch'], $configJson, $content, $password, date("m"), $_SESSION['ano_oper'], $cnpjEmpresa,"unica");  
        
        $dataXML = $bd->Execute($sql);    
        $baixou  = $dataXML->RecordCount() > 0 ? true : false;
        
    }
    
}
else if ( $_POST['tipoBusca'] == "manifesta" ){
    $dados = $bd->Execute($sql =  "SELECT chnfe, nota.id_nota  FROM  t_dfe_service_docs AS tdsd LEFT JOIN  nota ON ( nota.chave_acesso = tdsd.chnfe ) WHERE tipo = 'procNF' AND tdsd.status ='ABERTO';");    

    # - VALIDANDO DADOS
    if ( $dados->RecordCount() > 0 ){
        while ( !$dados->EOF ){

            sendCienciaOp($dados->fields['chnfe'], $dados->fields['id_nota'], "210200", $_SESSION['id_usuario'], $configJson, $content, $password, "");

            $dados->MoveNext();
        }
    }
}
else if ( $_POST['tipoBusca'] == "manifestaNF" ){
    
    #AQUI VALIDAMOS SE A CHAVE JÁ FOI DADA CIÊNCIA DA OPERAÇÃO
    $dados = $bd->Execute($sql =  "SELECT id_nota FROM nota WHERE chave_acesso = '{$_POST['ch']}';");    
   /**
    * 2 - Método de manifestação do destinatário aqui iremos efetuar a @ CIÊNCIA DA OPERAÇÃO, para a nota ser efetuada o Download.
    * @global type $bd
    * @param type $chNFe
    * @param type $idNota
    * @param type $tpEvento
    *     -> Confirmação da Operação - Codigo 210200 - Justifica ( Não obrigatória )
          -> Ciência da Emissão      - Codigo 210210 - Justifica ( Não obrigatória )
          -> Desconhecimento da Op.  - Codigo 210220 - Justifica ( Não obrigatória )
          -> Operação não Realizada  - Codigo 210240 - Justifica ( Obrigatória     )
    * @param type $id_usuario
    * @param type $configJson
    * @param type $content
    * @param type $password
    * @param string $xJus
    */
    
    comunicaNFe($_POST['ch'], $dados->fields['id_nota'], "210240", $_SESSION['id_usuario'], $configJson, $content, $password, "NOTA EMITIDA ERRONEAMENTE", $cnpjEmpresa);

}


#EFETUA O TRATAMENTO DO RETURNO
if ( $timeOut ){ $retornoValue = "TIME_OUT";}
else{            $retornoValue = "SUCESSO";             } 
print json_encode([
        "status"           => $retornoValue
    ]);